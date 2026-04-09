<?php

namespace App\Enums;

enum CollaborationStatus: string
{
  case Pending  = 'pending';
  case Accepted = 'accepted';
  case Declined = 'declined';
}
