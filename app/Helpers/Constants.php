<?php

namespace App\Helpers;

class Constants
{
  const DATE_FORMAT = 'Y-m-d';
  const BOOK_FREE = 1;
  const BOOK_LENDING = 2;

  const USER_BOOKING = 1;
  const USER_RETURNED = 2;

  const BOOK_STATUS = [
    1 => 'Free',
    2 => 'Borrowed'
  ];

  const GENDER = [
    1 => 'Male',
    2 => 'Female'
  ];
}