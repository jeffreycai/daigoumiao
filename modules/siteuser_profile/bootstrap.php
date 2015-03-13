<?php
define('AVATAR_FOLDER', __DIR__ . DS . 'avatars');
// check avatar folder exist and writable
if (!is_writable(AVATAR_FOLDER)) {
  die('siteuser_profile module: Avatar folder needs to be writable.');
}