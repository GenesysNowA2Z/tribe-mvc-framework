<?php

    namespace app\core;
    abstract class UserModel extends DataModel {
        abstract public function getDisplayName(): string;
    }