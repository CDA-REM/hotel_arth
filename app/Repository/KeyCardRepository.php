<?php

namespace App\Repository;

use App\Http\Resources\KeyCardResource;
use App\Models\KeyCard;
use App\Models\Room;

class KeyCardRepository
{
    /**
     * @param $roomId
     * @return mixed
     */
    public static function getCurrentCards($roomId): mixed
    {
        // Create empty array $keyCardsAlreadyInUse
        $keyCardsAlreadyInUse = [];
        // Get all keycards whose room_id is equal to the room_id of the room for which we want to know/display the number of keycards.
        foreach (KeyCard::all() as $keyCard) {
            if ($keyCard->room_id == $roomId) {
                // Add the keycard to the array $keyCardsAlreadyInUse
                array_push($keyCardsAlreadyInUse, $keyCard);
            }
        }
        // Return number of elements in array $keyCardsAlreadyInUse
        return count($keyCardsAlreadyInUse);
    }

    /**
     * @param $roomId
     * @return bool
     */
    public static function checkIfKeyCardCreationIsAllowed($roomId): bool
    {
        // Return true if the number of keycards is less than 2, otherwise return false
        return KeyCardRepository::getCurrentCards($roomId) < 2 ? true : false;
    }

    /**
     * @param $room_id
     * @return mixed
     */
    public static function allowsRoomAccess($room_id, $key_card_id): mixed
    {
        //Récupérer la $keycard->room_id
        $keycard = KeyCard::findorFail($key_card_id);
        //Créer une variable pour stocker la valeur de $keycard->room_id
        $keyCard_room_id = $keycard->room_id;

        // Créer une variable pour stocker la date du jour
        $today = date("Y-m-d");
        // Créer une variable pour stocker la date de fin de la réservation
        $end_date = $keycard->reservation->end_date;
        // Créer une variable pour stocker la valeur du checkout de la réservation
        $checkout = $keycard->reservation->checkout;

        //Vérifier si $room_id est égale à $keycard->room_id
        if ($keyCard_room_id == $room_id && !isset($checkout) && $today <= $end_date) {
            // retourner un objet json avec un message et le status de la requete
            return response()->json([
                'message' => 'Vous pouvez accéder à la chambre',
                'status' => 200
            ]);
            return true;
        } else {
            // retourner un objet json avec un message et le status de la requete
            return response()->json([
                'message' => 'Vous ne pouvez pas accéder à la chambre',
                'status' => 403
            ]);
        }
    }
}
