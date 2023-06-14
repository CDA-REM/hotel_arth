<?php

namespace App\Repository;

use App\Models\KeyCard;

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
        dd(count($keyCardsAlreadyInUse));
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
}
