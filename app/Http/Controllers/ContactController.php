<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with(['category', 'phoneNumbers']);

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('favorites') && $request->favorites == '1') {
            $query->favorites();
        }

        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $contacts = $query->paginate(12);
        $categories = Category::all();

        return view('contacts.index', compact('contacts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('contacts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'phone_numbers' => 'nullable|array',
            'phone_numbers.*.type' => 'required|in:mobile,home,work',
            'phone_numbers.*.number' => 'required|string|max:20',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact = Contact::create($validated);

        if ($request->has('phone_numbers')) {
            foreach ($request->phone_numbers as $phone) {
                if (!empty($phone['number'])) {
                    $contact->phoneNumbers()->create($phone);
                }
            }
        }

        return redirect()->route('contacts.show', $contact)
            ->with('success', 'Contacto creado exitosamente.');
    }

    public function show(Contact $contact)
    {
        $contact->load(['category', 'phoneNumbers']);
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $categories = Category::all();
        $contact->load('phoneNumbers');
        return view('contacts.edit', compact('contact', 'categories'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'phone_numbers' => 'nullable|array',
            'phone_numbers.*.type' => 'required|in:mobile,home,work',
            'phone_numbers.*.number' => 'required|string|max:20',
        ]);

        if ($request->hasFile('photo')) {
            if ($contact->photo) {
                Storage::disk('public')->delete($contact->photo);
            }
            $validated['photo'] = $request->file('photo')->store('contacts', 'public');
        }

        $contact->update($validated);

        $contact->phoneNumbers()->delete();
        
        if ($request->has('phone_numbers')) {
            foreach ($request->phone_numbers as $phone) {
                if (!empty($phone['number'])) {
                    $contact->phoneNumbers()->create($phone);
                }
            }
        }

        return redirect()->route('contacts.show', $contact)
            ->with('success', 'Contacto actualizado exitosamente.');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->photo) {
            Storage::disk('public')->delete($contact->photo);
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contacto eliminado exitosamente.');
    }

    public function toggleFavorite(Contact $contact)
    {
        $contact->update([
            'is_favorite' => !$contact->is_favorite
        ]);

        return back()->with('success', $contact->is_favorite ? 
            'Contacto marcado como favorito.' : 
            'Contacto desmarcado como favorito.');
    }
}
