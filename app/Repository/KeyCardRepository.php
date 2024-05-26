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

    /**
     * Check if reservationId has $roomId
     * @param $roomId
     * @param $reservationId
     * @return bool
     */
    public static function checkReservationHasRoomId($roomId, $reservationId): bool
{
    // Create empty array $reservationIdHasRoomId
    $roomsWhereTheIdOfReservationEqualReservationId = [];

    // Find if $reservationId exist
    if(Reservation::where('id',$reservationId)->first() == null){
        throw new Exception("Ce numéro de réservation n'existe pas");
    }

    // Find if $roomId exist
    if(Room::where('id', $roomId)->first() == null){
        throw new Exception("Cet identifiant de chambre n'existe pas");
    }

    // Find rooms where the id of reservation equal $reservationId
    $rooms = Reservation::find($reservationId)->rooms;
    foreach ($rooms as $room){
        if($room->id == $roomId){
            array_push($roomsWhereTheIdOfReservationEqualReservationId, $room);
        }
    }

    // Throw exception if couple roomId / reservationId doesn't exist
    if(empty($roomsWhereTheIdOfReservationEqualReservationId)){
        throw new Exception("Veuillez vérifier le numéro de réservation et / ou l'identifiant de chambre");

    }
    return true;
}

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

        KeyCardRepository::checkReservationHasRoomId($roomId, $reservationId);
        foreach (KeyCard::all() as $keyCard) {
            if ($keyCard->reservation_id == $reservationId && $keyCard->room_id == $roomId) {
                // Add the keycard to the array $keyCardsAlreadyInUse
                array_push($keyCardsAlreadyInUse, $keyCard);
            }
        }
        // Return number of elements in array $keyCardsAlreadyInUse
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
     * @param $key_code
     * @return bool
     */

//    public static function allowsRoomAccess($room_id, $key_code): bool
//    {
//
//        //Récupérer la $keycard->room_id
//        $keycard= KeyCard::where("key_code", $key_code)->first();
//
//        //Créer une variable pour stocker la valeur de $keycard->room_id
//        $keyCard_room_id = $keycard->room_id;
//
//        // Récupérer l'id de la key card
//        $key_card_id = $keycard->id;
//
//        // Créer une variable pour stocker la date du jour
//        $today = date("Y-m-d");
//        // Créer une variable pour stocker la date de fin de la réservation
//        $end_date = $keycard->reservation->end_date;
//        // Créer une variable pour stocker la valeur du checkout de la réservation
//        $checkout = $keycard->reservation->checkout;
//        // Créer une variable pour stocker la valeur du checkin de la réservation
//        $checkin = $keycard->reservation->checkin;
//
//        //Vérifier si $room_id est égale à $keycard->room_id
//        if ($keyCard_room_id == $room_id && !isset($checkout) && $today <= $end_date && isset($checkin)) {
//            // enregistrer la date et l'heure dans les statistiques
//            StatisticRepository::updateStatistic($key_card_id);
//            // retourner un objet json avec un message et le status de la requete
//            return true;
//        } else {
//            // retourner un objet json avec un message et le status de la requete
//            return false;
//        }
//    }
    public static function allowsRoomAccess($room_id, $key_code): bool
    {

        //Récupérer la $keycard->room_id sinon erreur
        if(!KeyCard::where("key_code", $key_code)->first()){
            throw new Exception("Cette carte est invalide", 502);
        }
        $keycard= KeyCard::where("key_code", $key_code)->first();

        //Créer une variable pour stocker la valeur de $keycard->room_id
        $keyCard_room_id = $keycard->room_id;

        // Vérifier que room_id existe sinon erreur
        if(!Room::where("id", $room_id)->first()){
            throw new Exception("Cet identifiant de chambre n'existe pas", 502);
        }

        // Récupérer l'id de la key card
        $key_card_id = $keycard->id;

        // Créer une variable pour stocker la date du jour
        $today = date("Y-m-d");
        // Créer une variable pour stocker la date de fin de la réservation
        $end_date = $keycard->reservation->end_date;
        // Créer une variable pour stocker la valeur du checkout de la réservation
        $checkout = $keycard->reservation->checkout;
        // Créer une variable pour stocker la valeur du checkin de la réservation
        $checkin = $keycard->reservation->checkin;

        //Vérifier si $room_id est égale à $keycard->room_id
        if ($keyCard_room_id == $room_id && !isset($checkout) && $today <= $end_date && isset($checkin)) {
            // enregistrer la date et l'heure dans les statistiques
            StatisticRepository::updateStatistic($key_card_id);
            // retourner un objet json avec un message et le status de la requete
            return true;
        } else {
            // retourner un objet json avec un message et le status de la requete
            return false;
        }
    }
}
