<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactDetailResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\SearchContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $contacts = Contact::when($query, function ($queryBuilder, $query) {
            return $queryBuilder->where('name', 'like', "%$query%")
                ->orWhere('name', 'like', "%$query%")
                ->orWhere('country_code', 'like', "%$query%")
                ->orWhere('phone_number', 'like', "%$query%")
            ;
        })
            ->latest("id")->paginate(10)->withQueryString();
        return ContactDetailResource::collection($contacts);
    }


    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "country_code" => "required|min:1|max:265",
            "phone_number" => "required",
        ]);

        $contact = Contact::create([
            "name" => $request->name,
            "country_code" => $request->country_code,
            "phone_number" => $request->phone_number,
            "user_id" => Auth::id(),
        ]);

        return new ContactDetailResource($contact);
    }


    public function show(string $id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json([
                // "success" => false,
                "message" => "Contact not found",

            ], 404);
        }

        // return response()->json([
        //     "data" => $contact
        // ]);
        return new ContactDetailResource($contact);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "nullable|min:3|max:20",
            "country_code" => "nullable|integer|min:1|max:265",
            "phone_number" => "nullable|min:7|max:15",
        ]);

        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json([
                "message" => "Contact not found",
            ], 404);
        }

        // $contact->update([
        //     "name" => $request->name,
        //     "country_code" => $request->country_code,
        //     "phone_number" => $request->phone_number
        // ]);

        // $contact->update($request->all());

        if ($request->has('name')) {
            $contact->name = $request->name;
        }

        if ($request->has('country_code')) {
            $contact->country_code = $request->country_code;
        }

        if ($request->has('phone_number')) {
            $contact->phone_number = $request->phone_number;
        }

        $contact->update();

        return new ContactDetailResource($contact);
    }


    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json([
                // "success" => false,
                "message" => "Contact not found",

            ], 404);
        }
        $contact->delete();

        return response()->json([
            "message" => "Contact is deleted",
        ]);
    }

    public function restore(string $id)
    {
        $contact = Contact::withTrashed()->find($id);
        $contact->restore();
        return response()->json([
            "message" => "Contact is restored"
        ]);
    }

    public function forceDelete(string $id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json([
                // "success" => false,
                "message" => "Contact not found",
            ], 404);
        }
        $contact->forceDelete();

        return response()->json([
            "message" => "Contact is force deleted",
        ]);
    }

}
