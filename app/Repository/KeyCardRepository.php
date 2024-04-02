<?php

namespace App\Repository;

use App\Models\KeyCard;
use App\Models\Reservation;
use App\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\Constraint\Count;
use Ramsey\Collection\Collection;

class KeyCardRepository
{
//    /**
//     * Get the number of keycards for a room
//     * @param $roomId
//     * @return int
//     */
//    public static function getCurrentCards($roomId): int
//    {
//        // Create empty array $keyCardsAlreadyInUse
//        $keyCardsAlreadyInUse = [];
//        // Get all keycards whose room_id is equal to the room_id of the room for which we want to know/display the number of keycards.
//        foreach (KeyCard::all() as $keyCard) {
//            if ($keyCard->room_id == $roomId) {
//                // Add the keycard to the array $keyCardsAlreadyInUse
//                array_push($keyCardsAlreadyInUse, $keyCard);
//            }
//        }
//        // Return number of elements in array $keyCardsAlreadyInUse
//        return count($keyCardsAlreadyInUse);
//    }
//
//    /**
//     * Verifies if the number of keycards is less than 2
//     * @param $roomId
//     * @return bool
//     */
//    public static function checkIfKeyCardCreationIsAllowed($roomId): bool
//    {
//        // Return true if the number of keycards is less than 2, otherwise return false
//        return KeyCardRepository::getCurrentCards($roomId) < 2 ? true : false;
//    }
    /**
     * Get the number of keycards for a room
     * @param $roomId
     * @param $reservationId
     * @return int
     */
    public static function getCurrentCards($roomId, $reservationId): int
    {
        // Create empty array $keyCardsAlreadyInUse
        $keyCardsAlreadyInUse = [];

        // Find the current reservation
        $reservation = Reservation::where('id',$reservationId)->first();
            $reservation_id = $reservation->id;

            // Find the current roomId in reservation_room
            $room = $reservation->rooms()->where('id', $roomId)->first();

        // Get all keycards whose room_id is equal to the room_id of the room for which we want to know/display the number of keycards.
        foreach (KeyCard::all() as $keyCard) {
//            dd($keyCard->room_id);
                if ($keyCard->reservation_id == $reservation_id && $keyCard->room_id == $roomId) {
                    // Add the keycard to the array $keyCardsAlreadyInUse
                    array_push($keyCardsAlreadyInUse, $keyCard);
                }
            }
        // Return number of elements in array $keyCardsAlreadyInUse
//        dd($keyCardsAlreadyInUse);
        return count($keyCardsAlreadyInUse);
    }

    /**
     * Verifies if the number of keycards is less than 2
     * @param $roomId
     * @param $reservationId
     * @return bool
     */
    public static function checkIfKeyCardCreationIsAllowed($roomId, $reservationId): bool
    {
        // Return true if the number of keycards is less than 2, otherwise return false
        return KeyCardRepository::getCurrentCards($roomId, $reservationId) < 2 ? true : false;
    }


    /**
     * Verify if the keycard is valid before allowing access to the room
     * @param $room_id
     * @param $key_card_id
     * @return JsonResponse
     * @throws Exception
     */
    public static function allowsRoomAccess($room_id, $key_card_id): JsonResponse
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
            // enregistrer la date et l'heure dans les statistiques
            StatisticRepository::updateStatistic($key_card_id);
            // retourner un objet json avec un message et le status de la requete
            return response()->json([
                'message' => 'Vous pouvez accéder à la chambre',
                'status' => 200
            ]);
        } else {
            // retourner un objet json avec un message et le status de la requete
            return response()->json([
                'message' => 'Vous ne pouvez pas accéder à la chambre',
                'status' => 403
            ]);
        }
    }


}
