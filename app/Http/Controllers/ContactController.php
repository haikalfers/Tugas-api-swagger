<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
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
 * @OA\Tag(name="Contacts")
 */

/**
 * @OA\Schema(
 *     schema="Contact",
 *     type="object",
 *     required={"first_name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", maxLength=50, example="John"),
 *     @OA\Property(property="last_name", type="string", maxLength=50, example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", maxLength=20, example="08123456789")
 * )
 * 
 * @OA\Schema(
 *     schema="ContactCreate",
 *     allOf={@OA\Schema(ref="#/components/schemas/Contact")},
 *     @OA\Property(property="user_id", type="integer", example=1)
 * )
 */

class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/contacts",
     *     tags={"Contacts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List contacts",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contact"))
     *     )
     * )
     */
    public function index()
    {
        /**
         * @OA\Get(
         *     path="/contacts",
         *     tags={"Contacts"},
         *     security={{"bearerAuth":{}}},
         *     @OA\Response(
         *         response=200,
         *         description="List of contacts",
         *         @OA\JsonContent(
         *             type="array",
         *             @OA\Items(ref="#/components/schemas/Contact")
         *         )
         *     )
         * )
         */

        $contacts = Contact::where('user_id', Auth::id())->get();
        return ContactResource::collection($contacts);
    }

    /**
     * @OA\Post(
     *     path="/contacts",
     *     tags={"Contacts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact created",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function store(ContactRequest $request): JsonResponse
    {
        /**
         * @OA\Post(
         *     path="/contacts",
         *     tags={"Contacts"},
         *     security={{"bearerAuth":{}}},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(ref="#/components/schemas/Contact")
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Contact created",
         *         @OA\JsonContent(ref="#/components/schemas/Contact")
         *     )
         * )
         */

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        
        $contact = Contact::create($data);
        
        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(201);
    }

    // Implement show(), update(), destroy() dengan pola yang sama
}
