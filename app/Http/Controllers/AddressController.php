<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


/**
 * @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */

/**
 * @OA\Tag(name="Addresses")
 */

/**
 * @OA\Schema(
 *     schema="Address",
 *     type="object",
 *     required={"country"},
 *     @OA\Property(property="street", type="string", example="123 Main St"),
 *     @OA\Property(property="city", type="string", example="Jakarta"),
 *     @OA\Property(property="province", type="string", example="DKI Jakarta"),
 *     @OA\Property(property="country", type="string", example="Indonesia"),
 *     @OA\Property(property="postal_code", type="string", example="12345")
 * )
 */
 
class AddressController extends Controller
{
    /**
     * @OA\Post(
     *     path="/contacts/{contactId}/addresses",
     *     tags={"Addresses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="contactId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address created",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     )
     * )
     */
    public function store(AddressRequest $request, $contactId): JsonResponse
    {
        $contact = Contact::where('user_id', Auth::id())
        ->findOrFail($contactId);

        
        $address = $contact->addresses()->create($request->validated());
        
        return (new AddressResource($address))
            ->response()
            ->setStatusCode(201);
    }

    // Implement update() dan destroy()
}
