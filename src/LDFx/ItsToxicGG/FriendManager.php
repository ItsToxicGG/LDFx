<?php

namespace LDFx\ItsToxicGG;

use pocketmine\player\Player;

class FriendManager{

    public function addfriend(Player $player1, string $player2){
        $player1name = $player1->getName();
        $player2name = $player2;
        $player1friend = LDFx::getInstance()->getDatabase()->query("SELECT friends FROM friend WHERE playername='$player1name'")->fetch_row();
        $player2friend = LDFx::getInstance()->getDatabase()->query("SELECT friends FROM friend WHERE playername='$player2name'")->fetch_row();
        $player1friend = unserialize(base64_decode($player1friend[0]));
        $player2friend = unserialize(base64_decode($player2friend[0]));
        array_push($player1friend, $player2name);
        array_push($player2friend, $player1name);
        $player1friend = base64_encode(serialize($player1friend));
        $player2friend = base64_encode(serialize($player2friend));
        LDFx::getInstance()->getDatabase()->query("UPDATE friend SET friends='$player1friend' WHERE username='$player1name'");
        LDFx::getInstance()->getDatabase()->query("UPDATE friend SET friends='$player2friend' WHERE username='$player2name'");
    }

    public function unfriend(Player $player1, string $player2){
        $player1name = $player1->getName();
        $player1friend = LDFx::getInstance()->getDatabase()->query("SELECT friends FROM friend WHERE playername='$player1name'")->fetch_row();
        $player2friend = LDFx::getInstance()->getDatabase()->query("SELECT friends FROM friend WHERE playername='$player2'")->fetch_row();
        $player1friend = unserialize(base64_decode($player1friend[0]));
        $player2friend = unserialize(base64_decode($player2friend[0]));
        $index1 = array_search($player2, $player1friend);
        $index2 = array_search($player1name, $player2friend);
        unset($player1friend[$index1]);
        unset($player2friend[$index2]);
        $player1friend = base64_encode(serialize($player1friend));
        $player2friend = base64_encode(serialize($player2friend));
        LDFx::getInstance()->getDatabase()->query("UPDATE friend SET friends='$player1friend' WHERE username='$player1name'");
        LDFx::getInstance()->getDatabase()->query("UPDATE friend SET friends='$player2friend' WHERE username='$player2'");
    }

    public function denyrequest(Player $player1, string $player2name){
        LDFx::getInstance()->getDatabase()->query("DELETE FROM request WHERE player1name='{$player1->getName()}' AND player2name='$player2name'");
    }

    public function accrequest(Player $player1, string $player2name){
        LDFx::getInstance()->getDatabase()->query("DELETE FROM request WHERE player1name='{$player1->getName()}' AND player2name='$player2name'");
        $this->addfriend($player1, $player2name);
    }

    public function getArrayFriend(Player $player){
        $name = $player->getName();
        $player1friend = LDFx::getInstance()->getDatabase()->query("SELECT friends FROM friend WHERE playername='$name'")->fetch_row();
        $player1friend = unserialize(base64_decode($player1friend[0]));
        return $player1friend;
    }

    public function friendrequest(Player $player1, Player $player2){
        LDFx::getInstance()->getDatabase()->query("INSERT INTO request VALUES(null, '{$player2->getName()}', '{$player1->getName()}')");
        $player1->sendMessage("Succesfully Send Friend Request to {$player2->getName()}");
    }

    public function getArrayRequest(Player $player){
        $playername = $player->getName();
        $array = LDFx::getInstance()->getDatabase()->query("SELECT player2name FROM request WHERE player1name='$playername'")->fetch_row();
        return $array;
    }
}
