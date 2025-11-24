<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\Setting; // Import the Setting model

class Helpers
{
  /**
   * Generate menu attributes for semi-dark mode
   *
   * @param bool $semiDarkEnabled Whether semi-dark mode is enabled
   * @return array HTML attributes for the menu element
   */
  public static function getMenuAttributes($semiDarkEnabled)
  {
    $attributes = [];

    if ($semiDarkEnabled) {
      $attributes['data-bs-theme'] = 'dark';
    }

    return $attributes;
  }

  public static function appClasses()
  {
    // Fetch all settings from the database
    $dbSettings = Setting::all()->keyBy('key');

    // Default data array, now with values potentially overridden by DB settings
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => $dbSettings['myTheme']->value ?? 'light',
      'mySkins' => $dbSettings['mySkins']->value ?? 'default',
      'hasSemiDark' => (bool) ($dbSettings['hasSemiDark']->value ?? false),
      'myRTLMode' => (bool) ($dbSettings['myRTLMode']->value ?? true),
      'hasCustomizer' => false, // Always false as customizer is removed
      'showDropdownOnHover' => true, // Default value
      'displayCustomizer' => false, // Always false as customizer is removed
      'contentLayout' => $dbSettings['contentLayout']->value ?? 'compact',
      'headerType' => $dbSettings['headerType']->value ?? 'fixed',
      'navbarType' => $dbSettings['navbarType']->value ?? 'sticky',
      'menuFixed' => (bool) ($dbSettings['menuFixed']->value ?? true),
      'menuCollapsed' => (bool) ($dbSettings['menuCollapsed']->value ?? false),
      'footerFixed' => (bool) ($dbSettings['footerFixed']->value ?? false),
      'customizerControls' => [], // Always empty as customizer is removed
      'primaryColor' => $dbSettings['primaryColor']->value ?? null, // Custom primary color
    ];

    $data = config('custom.custom');
    $data = array_merge($DefaultData, $data);

    // All options available in the template (used for validation/fallback)
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank', 'front'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'contentLayout' => ['compact', 'wide'],
      'headerType' => ['fixed', 'static'],
      'navbarType' => ['sticky', 'static', 'hidden'],
      'myTheme' => ['light', 'dark', 'system'],
      'mySkins' => ['default', 'bordered', 'raspberry'],
      'hasSemiDark' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'footerFixed' => [true, false],
      'customizerControls' => [],
    ];

    // Validate and set default values if DB settings are invalid or missing
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          if (is_string($data[$key])) {
            if (isset($data[$key]) && $data[$key] !== null) {
              if (!in_array($data[$key], $value)) {
                $data[$key] = $DefaultData[$key];
              }
            } else {
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }

    $themeVal = $data['myTheme'] == "dark" ? "dark" : "light";
    $themeUpdatedVal = $data['myTheme'] == "dark" ? "dark" : $data['myTheme'];

    $layoutName = $data['myLayout'];
    $isAdmin = !Str::contains($layoutName, 'front');

    // Use DB settings directly, no need for cookies for these
    $primaryColor = $data['primaryColor'];
    $skinName = $data['mySkins'];
    $semiDarkEnabled = $data['hasSemiDark'];
    $menuCollapsedFromDb = $data['menuCollapsed'];
    $contentLayoutFromDb = $data['contentLayout'];
    $navbarTypeFromDb = $data['navbarType'];
    $headerTypeFromDb = $data['headerType'];
    $directionVal = $data['myRTLMode'] ? 'rtl' : 'ltr';

    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'skins' => $data['mySkins'],
      'skinName' => $skinName,
      'semiDark' => $semiDarkEnabled,
      'color' => $primaryColor,
      'theme' => $themeVal,
      'themeOpt' => $data['myTheme'],
      'themeOptVal' => $themeUpdatedVal,
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $directionVal,
      'menuCollapsed' => $menuCollapsedFromDb,
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'contentLayout' => $contentLayoutFromDb,
      'headerType' => $headerTypeFromDb,
      'navbarType' => $navbarTypeFromDb,
      'menuFixed' => $data['menuFixed'],
      'footerFixed' => $data['footerFixed'],
      'customizerControls' => $data['customizerControls'],
      'menuAttributes' => self::getMenuAttributes($semiDarkEnabled),
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] === 'true' || $layoutClasses['menuCollapsed'] === true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    } else {
      $layoutClasses['menuCollapsed'] = '';
    }

    // Header Type
    if ($layoutClasses['headerType'] == 'fixed') {
      $layoutClasses['headerType'] = 'layout-menu-fixed';
    }
    // Navbar Type
    if ($layoutClasses['navbarType'] == 'sticky') {
      $layoutClasses['navbarType'] = 'layout-navbar-fixed';
    } elseif ($layoutClasses['navbarType'] == 'static') {
      $layoutClasses['navbarType'] = '';
    } else {
      $layoutClasses['navbarType'] = 'layout-navbar-hidden';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }


    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === 'true' ? 'rtl' : 'ltr') : 'rtl';
    } else {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) && $_COOKIE['direction'] === 'true' ? 'rtl' : 'ltr';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = true;
    } else {
      $layoutClasses['showDropdownOnHover'] = false;
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = true;
    } else {
      $layoutClasses['displayCustomizer'] = false;
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }

  /**
   * Generate CSS for primary color
   *
   * @param string $color Hex color code for primary color
   * @return string CSS for primary color
   */
  public static function generatePrimaryColorCSS($color)
  {
    if (!$color) return '';

    // Check if the color actually came from a cookie or explicit configuration
    // Don't generate CSS if there's no specific need for a custom color
    $configColor = config('custom.custom.primaryColor', null);
    $isFromCookie = isset($_COOKIE['admin-primaryColor']) || isset($_COOKIE['front-primaryColor']);

    if (!$configColor && !$isFromCookie) return '';

    $r = hexdec(substr($color, 1, 2));
    $g = hexdec(substr($color, 3, 2));
    $b = hexdec(substr($color, 5, 2));

    // Calculate contrast color based on YIQ formula
    $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    $contrastColor = ($yiq >= 150) ? '#000' : '#fff';

    return <<<CSS
:root, [data-bs-theme=light], [data-bs-theme=dark] {
  --bs-primary: {$color};
  --bs-primary-rgb: {$r}, {$g}, {$b};
  --bs-primary-bg-subtle: rgba({$r}, {$g}, {$b}, 0.1);
  --bs-primary-border-subtle: rgba({$r}, {$g}, {$b}, 0.3);
  --bs-primary-contrast: {$contrastColor};
}
CSS;
  }
}
