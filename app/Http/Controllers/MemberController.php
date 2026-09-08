<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Andi Saputra', 'nim' => '2210101001', 'email' => 'andi.saputra@example.com', 'nomor_telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 10, Surabaya', 'status' => 1],
        ['id' => 2, 'nama' => 'Budi Santoso', 'nim' => '2210101002', 'email' => 'budi.santoso@example.com', 'nomor_telepon' => '081234567891', 'alamat' => 'Jl. Diponegoro No. 5, Surabaya', 'status' => 1],
        ['id' => 3, 'nama' => 'Citra Dewi', 'nim' => '2210101003', 'email' => 'citra.dewi@example.com', 'nomor_telepon' => '081234567892', 'alamat' => 'Jl. Ahmad Yani No. 21, Surabaya', 'status' => 0],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        $member = collect($this->members)->firstWhere('id', (int) $id);

        abort_if(! $member, 404);

        return view('members.show', compact('member'));
    }

    public function edit(string $id)
    {
        $member = collect($this->members)->firstWhere('id', (int) $id);

        abort_if(! $member, 404);

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:200',
            'nim' => 'required|digits_between:8,10',
            'email' => 'required|email|unique:members,email,'.$id.'|max:100',
            'nomor_telepon' => 'required|string|digits_between:10,15',
            'alamat' => 'required|string|max:200',
            'status' => 'required|boolean',
        ]);

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil diperbarui (data dummy, belum tersimpan ke database).");
    }

    public function destroy(string $id)
    {
        return redirect()->route('members.index')
            ->with('success', "Anggota dengan id {$id} berhasil dihapus (data dummy, belum tersimpan ke database).");
    }
}