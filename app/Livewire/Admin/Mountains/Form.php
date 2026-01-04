<?php
// ==========================================
// APP/LIVEWIRE/ADMIN/MOUNTAINS/FORM.PHP
// ==========================================

namespace App\Livewire\Admin\Mountains;

use App\Models\Mountain;
use Livewire\Attributes\Layout;
use App\Models\HikingRoute;
use App\Traits\HasFileUpload;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


#[layout('layouts.admin')]
class Form extends Component
{
    use WithFileUploads, HasFileUpload;

    public ?Mountain $mountain = null;
    
    // Mountain fields
    public $nama_gunung;
    public $lokasi;
    public $ketinggian;
    public $tingkat_kesulitan = 'sedang';
    public $deskripsi;
    public $image;
    public $existingImage;
    public $is_active = true;

    // Hiking Routes
    public $routes = [];
    public $showRouteForm = false;

    protected function rules()
    {
        return [
            'nama_gunung' => 'required|string|max:100',
            'lokasi' => 'required|string|max:200',
            'ketinggian' => 'required|integer|min:0',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit,sangat sulit',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'routes.*.nama_jalur' => 'required|string|max:100',
            'routes.*.tingkat_kesulitan' => 'required|in:mudah,sedang,sulit,sangat sulit',
            'routes.*.estimasi_waktu_hari' => 'required|integer|min:1',
            'routes.*.jarak_km' => 'nullable|numeric|min:0',
            'routes.*.deskripsi_jalur' => 'nullable|string',
            'routes.*.is_available' => 'boolean',
        ];
    }

    public function mount(?Mountain $mountain = null)
    {
        if ($mountain && $mountain->exists) {
            $this->mountain = $mountain;
            $this->fill($mountain->only([
                'nama_gunung', 'lokasi', 'ketinggian', 'tingkat_kesulitan',
                'deskripsi', 'is_active'
            ]));
            $this->existingImage = $mountain->image_url;
            
            // Load existing routes
            $this->routes = $mountain->hikingRoutes->map(function($route) {
                return [
                    'id' => $route->id,
                    'nama_jalur' => $route->nama_jalur,
                    'tingkat_kesulitan' => $route->tingkat_kesulitan,
                    'estimasi_waktu_hari' => $route->estimasi_waktu_hari,
                    'jarak_km' => $route->jarak_km,
                    'deskripsi_jalur' => $route->deskripsi_jalur,
                    'is_available' => $route->is_available,
                ];
            })->toArray();
        }
    }

    public function addRoute()
    {
        $this->routes[] = [
            'id' => null,
            'nama_jalur' => '',
            'tingkat_kesulitan' => 'sedang',
            'estimasi_waktu_hari' => 2,
            'jarak_km' => null,
            'deskripsi_jalur' => '',
            'is_available' => true,
        ];
        $this->showRouteForm = true;
    }

    public function removeRoute($index)
    {
        // If route has ID, mark for deletion
        if (isset($this->routes[$index]['id'])) {
            HikingRoute::find($this->routes[$index]['id'])?->delete();
        }
        unset($this->routes[$index]);
        $this->routes = array_values($this->routes);
    }

    public function removeImage()
    {
        if ($this->mountain && $this->mountain->image_url) {
            $this->deleteImage($this->mountain->image_url);
            $this->mountain->update(['image_url' => null]);
            $this->existingImage = null;
            session()->flash('success', 'Gambar berhasil dihapus!');
        }
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        
        try {
            $mountainData = [
                'nama_gunung' => $this->nama_gunung,
                'lokasi' => $this->lokasi,
                'ketinggian' => $this->ketinggian,
                'tingkat_kesulitan' => $this->tingkat_kesulitan,
                'deskripsi' => $this->deskripsi,
                'is_active' => $this->is_active,
                'created_by' => Auth::id(),
            ];

            // Upload image if provided
            if ($this->image) {
                // Delete old image if exists
                if ($this->mountain && $this->mountain->image_url) {
                    $this->deleteImage($this->mountain->image_url);
                }
                $mountainData['image_url'] = $this->uploadImage($this->image, 'mountains');
            }

            if ($this->mountain) {
                $this->mountain->update($mountainData);
                $action = 'update';
            } else {
                $this->mountain = Mountain::create($mountainData);
                $action = 'create';
            }

            // Sync hiking routes
            $existingRouteIds = collect($this->routes)->pluck('id')->filter()->toArray();
            
            // Delete routes that are not in the list
            HikingRoute::where('mountain_id', $this->mountain->id)
                ->whereNotIn('id', $existingRouteIds)
                ->delete();

            // Create or update routes
            foreach ($this->routes as $routeData) {
                if ($routeData['id']) {
                    HikingRoute::find($routeData['id'])->update([
                        'nama_jalur' => $routeData['nama_jalur'],
                        'tingkat_kesulitan' => $routeData['tingkat_kesulitan'],
                        'estimasi_waktu_hari' => $routeData['estimasi_waktu_hari'],
                        'jarak_km' => $routeData['jarak_km'],
                        'deskripsi_jalur' => $routeData['deskripsi_jalur'],
                        'is_available' => $routeData['is_available'] ?? true,
                    ]);
                } else {
                    HikingRoute::create([
                        'mountain_id' => $this->mountain->id,
                        'nama_jalur' => $routeData['nama_jalur'],
                        'tingkat_kesulitan' => $routeData['tingkat_kesulitan'],
                        'estimasi_waktu_hari' => $routeData['estimasi_waktu_hari'],
                        'jarak_km' => $routeData['jarak_km'],
                        'deskripsi_jalur' => $routeData['deskripsi_jalur'],
                        'is_available' => $routeData['is_available'] ?? true,
                    ]);
                }
            }

            // Log activity
            \App\Models\ActivityLog::log(
                $action,
                'mountains',
                $this->mountain->id,
                ucfirst($action) . ' mountain: ' . $this->mountain->nama_gunung
            );

            DB::commit();

            session()->flash('success', 'Data gunung berhasil disimpan!');
            return redirect()->route('admin.mountains.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.mountains.form');
    }
}