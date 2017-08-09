<?php

final class VisitorManager {

    public static function getVisitors() {

        return db::query("SELECT * FROM `visitor`;");
    }

    public static function getVisitorsForEvent() {

        return db::query("SELECT `id`, `firstname`, `lastname`, `idcompany`, `linkedin`, `facebook`, `twitter` FROM `visitor`;");
    }

    public static function getVisitor($id) {

        return db::queryFirst("SELECT * FROM `visitor` WHERE `id` = ?", $id);
    }

    public static function addVisitor($firstname, $lastname, $idcompany, $linkedin, $facebook, $twitter) {

        return db::insert("INSERT INTO `visitor` (`firstname`, `lastname`, `idcompany`, `linkedin`, `facebook`, `twitter`) VALUES (?,?,?,?,?,?);", 
        array($firstname, $lastname, $idcompany, $linkedin, $facebook, $twitter));
    }

    public static function updateVisitor($id, $firstname, $lastname, $idcompany, $linkedin, $facebook, $twitter) {

        return db::execute("UPDATE `visitor` SET `firstname` = ?, `lastname` = ?, `idcompany` = ?, `linkedin` = ?, `facebook` = ?, `twitter` = ? WHERE `id` = ?;", 
            array($firstname, $lastname, $idcompany, $linkedin, $facebook, $twitter, $id)
        );
    }

    public static function updateAvatar($id, $avatar) {

        return db::execute("UPDATE `visitor` SET `avatar` = ? WHERE `id` = ?;", array($avatar, $id));
    }

    public static function getVisitorsOfToday() {

        return db::query("SELECT `visitor`.`id`, `visitor`.`idcompany`, `visitor`.`firstname`, `visitor`.`lastname`, `visitor`.`facebook`, `visitor`.`linkedin`, `visitor`.`twitter`, `company`.`name` AS `company` 
        FROM `event`
        LEFT JOIN `event_to_visitor` ON `event_to_visitor`.`idevent` = `event`.`id` 
        LEFT JOIN `visitor` ON `visitor`.`id` = `event_to_visitor`.`idvisitor`
        LEFT JOIN `company` ON `company`.`id` = `visitor`.`idcompany`
        WHERE `event`.`visitdate` = current_date() 
        AND `event_to_visitor`.`idvisitor` = `visitor`.`id`
        AND `event`.`isactive` = ?;", OPTION_YES);
    }

}