<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Contact;
use App\Traits\LogActivity;
use Illuminate\Http\Request;

class ContactController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.contacts.index', ['contacts' => Contact::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'role' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $contact = Contact::create($data);

        $this->logActivity(
            'create',
            'contacts',
            "Kontak pengelola '{$data['name']}' ditambahkan",
            $contact->id,
            null,
            $data
        );

        return redirect()->route('admin.contacts.index')->with('success', 'Kontak pengelola berhasil ditambahkan.');
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'role' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $oldValues = $contact->toArray();
        $contact->update($data);

        $this->logActivity(
            'update',
            'contacts',
            "Kontak pengelola '{$contact->name}' diperbarui",
            $contact->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.contacts.index')->with('success', 'Kontak pengelola berhasil diperbarui.');
    }

    public function destroy(Contact $contact)
    {
        $contactName = $contact->name;
        $contactId = $contact->id;
        $oldValues = $contact->toArray();
        $contact->delete();

        $this->logActivity(
            'delete',
            'contacts',
            "Kontak pengelola '{$contactName}' dihapus",
            $contactId,
            $oldValues,
            null
        );

        return redirect()->route('admin.contacts.index')->with('success', 'Kontak pengelola berhasil dihapus.');
    }
}
