<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;
use App\Http\Resources\ContactDetailResource;
use App\Http\Resources\FavouriteResource;
use App\Models\Contact;
use App\Models\Favourite;
use App\Models\User;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isTrue;

class FavouriteController extends Controller
{
//$user->favorite
    public function index(Favourite $favourite, User $user, Contact $contact)
    {
        $query = Contact::all();
        $item = $query->where("favorites","=","1");
        return response()->json(['message' => $item]);

    }

    public function addToFavorites(Contact $contact)
    {
        $contact_id = request()->contact_id;
        if (!$contact_id) {
            return response()->json([
                "message" => "contact not found!"
            ], 404);
        }
        if (is_null(Contact::find($contact_id))) {
            return response()->json([
                "message" => "contact not in range!"
            ], 404);
        }
        $con = $contact->find($contact_id);
        $con->update(['favorites' => true]);
        return response()->json(['message' => 'Contact added to favorites']);
    }

    public function removeFromFavorites(Contact $contact)
    {
        $contact_id = request()->contact_id;
        if (!$contact_id) {
            return response()->json([
                "message" => "contact not found!"
            ], 404);
        }
        if (is_null(Contact::find($contact_id))) {
            return response()->json([
                "message" => "contact not in range!"
            ], 404);
        }
        $con = $contact->find($contact_id);
        $con->update(['favorites' => false]);
        return response()->json(['message' => 'Contact removed from favorites']);
    }

    public function store(StoreFavouriteRequest $request)
    {
        //
    }

    public function show(Favourite $favourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavouriteRequest $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite $favourite)
    {
        //
    }
}
