<?php

namespace App\Repository;

class KeyCardRepository
{
    /**
     * @param $keyCardId
     * @return mixed
     */
    public static function getStatistic($keyCardId)
    {
        return StatisticRepository::getStatistic($keyCardId);
    }

    /**
     * @param $keyCardId
     * @return mixed
     */
    public static function getCurrentCards($roomId)
    {
        // créer un tableau vide $keyCardsAlreadyInUse
        $keyCardsAlreadyInUse = [];
        //récupérer toutes les keycards dont le room_id est égale au room_id de la chambre pour laquelle on veut afficher le nombre de keycards
        foreach (KeyCard::all() as $keyCard) {
            if ($keyCard->room_id == $roomId) {
                //ajouter la keycard au tableau $keyCardsAlreadyInUse
                array_push($keyCardsAlreadyInUse, $keyCard);
                //retourner le nombre d'éléments du tableau $keyCardsAlreadyInUse
                return $keyCardsAlreadyInUse;
            }
        }
        return count($keyCardsAlreadyInUse);
    }

    public static function checkIfKeyCardCreationIsAllowed($roomId)
    {
        //retourner true si le nombre de keycards est inférieur à 2, sinon retourner false
        return KeyCardRepository::getCurrentCards($roomId) < 2 ? true : false;
    }
}
