<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    
    // Properti Livewire boleh tetap bahasa Inggris (untuk wire:model di view)
    public $name = ''; 
    public $description = '';
    
    public $editingId = null;
    public $editName = '';
    public $editDescription = '';
    public $showForm = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            // UBAH: unique:tabel,kolom_database
            'name' => 'required|string|max:255|unique:categories,nama_kategori', 
            'description' => 'nullable|string|max:500',
        ];
    }

    protected function editRules()
    {
        return [
            // UBAH: unique:tabel,kolom_database,id_pengecualian
            'editName' => 'required|string|max:255|unique:categories,nama_kategori,' . $this->editingId,
            'editDescription' => 'nullable|string|max:500',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->reset(['name', 'description']);
            $this->resetValidation();
        }
    }

    public function save()
    {
        $this->validate();

        Category::create([
            // UBAH: Key array harus sesuai nama kolom database
            'nama_kategori' => $this->name, 
            'deskripsi' => $this->description,
        ]);

        session()->flash('success', 'Category created successfully.');
        
        $this->reset(['name', 'description', 'showForm']);
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->cancelEdit();
        
        $category = Category::findOrFail($id);
        $this->editingId = $id;
        
        // UBAH: Ambil dari kolom database yang benar
        $this->editName = $category->nama_kategori; 
        $this->editDescription = $category->deskripsi;
    }

    public function update()
    {
        $this->validate($this->editRules());

        $category = Category::findOrFail($this->editingId);
        $category->update([
            // UBAH: Update ke kolom database yang benar
            'nama_kategori' => $this->editName,
            'deskripsi' => $this->editDescription,
        ]);

        session()->flash('success', 'Category updated successfully.');
        
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'editName', 'editDescription']);
        $this->resetValidation();
    }

    #[On('confirm-delete')]
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->equipment()->count() > 0) {
            session()->flash('error', 'Cannot delete category with existing equipment.');
            return;
        }

        $category->delete();
        
        session()->flash('success', 'Category deleted successfully.');
    }

    public function render()
    {
        $categories = Category::withCount('equipment')
            ->when($this->search, function ($query) {
                // UBAH: Ganti 'name' jadi 'nama_kategori' dan 'description' jadi 'deskripsi'
                $query->where('nama_kategori', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            // UBAH: Order by kolom database yang benar
            ->orderBy('nama_kategori') 
            ->paginate(10);

        return view('livewire.admin.categories.index', [
            'categories' => $categories,
        ]);
    }
}