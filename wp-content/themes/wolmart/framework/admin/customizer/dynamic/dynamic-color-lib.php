<?php
/**
 * Wolmart Color Library
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'WolmartColorLib' ) ) :

	class WolmartColorLib {

		public static function fixColor( $c ) {
			foreach ( [ 0, 1, 2 ] as $i ) {
				if ( $c[ $i ] < 0 ) {
					$c[ $i ] = 0;
				}

				if ( $c[ $i ] > 255 ) {
					$c[ $i ] = 255;
				}
			}

			return $c;
		}

		public static function toHSL( $red, $green, $blue ) {
			$min = min( $red, $green, $blue );
			$max = max( $red, $green, $blue );

			$l = $min + $max;
			$d = $max - $min;

			if ( 0 === (int) $d ) {
				$h = 0;
				$s = 0;
			} else {
				if ( $l < 255 ) {
					$s = $d / $l;
				} else {
					$s = $d / ( 510 - $l );
				}

				if ( $red == $max ) {
					$h = 60 * ( $green - $blue ) / $d;
				} elseif ( $green == $max ) {
					$h = 60 * ( $blue - $red ) / $d + 120;
				} elseif ( $blue == $max ) {
					$h = 60 * ( $red - $green ) / $d + 240;
				}
			}

			return [ fmod( $h, 360 ), $s * 100, $l / 5.1 ];
		}

		public static function toRGB( $hue, $saturation, $lightness ) {
			if ( $hue < 0 ) {
				$hue += 360;
			}

			$h = $hue / 360;
			$s = min( 100, max( 0, $saturation ) ) / 100;
			$l = min( 100, max( 0, $lightness ) ) / 100;

			$m2 = $l <= 0.5 ? $l * ( $s + 1 ) : $l + $s - $l * $s;
			$m1 = $l * 2 - $m2;

			$r = self::hueToRGB( $m1, $m2, $h + 1 / 3 ) * 255;
			$g = self::hueToRGB( $m1, $m2, $h ) * 255;
			$b = self::hueToRGB( $m1, $m2, $h - 1 / 3 ) * 255;

			$out = [ ceil( $r ), ceil( $g ), ceil( $b ) ];

			return self::hexColor( $out );
		}

		public static function adjustHsl( $color, $amount ) {
			$hsl     = self::toHSL( $color[0], $color[1], $color[2] );
			$hsl[2] += $amount;
			$out     = self::toRGB( $hsl[0], $hsl[1], $hsl[2] );
			return $out;
		}

		public static function hueToRGB( $m1, $m2, $h ) {
			if ( $h < 0 ) {
				$h += 1;
			} elseif ( $h > 1 ) {
				$h -= 1;
			}

			if ( $h * 6 < 1 ) {
				return $m1 + ( $m2 - $m1 ) * $h * 6;
			}

			if ( $h * 2 < 1 ) {
				return $m2;
			}

			if ( $h * 3 < 2 ) {
				return $m1 + ( $m2 - $m1 ) * ( 2 / 3 - $h ) * 6;
			}

			return $m1;
		}

		private static function hexColor( $color ) {
			$rgb = dechex( ( $color[0] << 16 ) | ( $color[1] << 8 ) | $color[2] );
			return ( '#' . substr( '000000' . $rgb, -6 ) );
		}

		public static function hexToRGB( $hex_color, $str = true ) {
			$hex   = str_replace( '#', '', $hex_color );
			$red   = hexdec( strlen( $hex ) == 3 ? substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) : substr( $hex, 0, 2 ) );
			$green = hexdec( strlen( $hex ) == 3 ? substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) : substr( $hex, 2, 2 ) );
			$blue  = hexdec( strlen( $hex ) == 3 ? substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) : substr( $hex, 4, 2 ) );
			if ( $str ) {
				return $red . ',' . $green . ',' . $blue;
			} else {
				return array( $red, $green, $blue );
			}
		}

		public static function lighten( $color, $amount ) {
			if ( ! $color || 'transparent' == $color ) {
				return 'transparent';
			}
			return self::adjustHsl( self::hexToRGB( $color, false ), $amount );
		}

		public static function darken( $color, $amount ) {
			if ( ! $color || 'transparent' == $color ) {
				return 'transparent';
			}
			return self::adjustHsl( self::hexToRGB( $color, false ), -$amount );
		}

		public static function mix( $color1 = false, $color2 = false, $weight = false, $str = true ) {
			if ( ! $color1 || ! $color2 || ! $weight ) {
				return '';
			}
			$color1 = self::hexToRGB( $color1, false );
			$color2 = self::hexToRGB( $color2, false );
			$p      = $weight / 100.0;
			$w      = $p * 2 - 1;

			$a = 0;

			$w1 = ( ( ( ( $w * $a ) == -1 ) ? $w : ( $w + $a ) / ( 1 + $w * $a ) ) + 1 ) / 2;
			$w2 = 1 - $w1;

			$rgb = array(
				$color1[0] * $w1 + $color2[0] * $w2,
				$color1[1] * $w1 + $color2[1] * $w2,
				$color1[2] * $w1 + $color2[2] * $w2,
			);

			$rgb = self::fixColor( $rgb );
			if ( $str ) {
				return self::hexColor( $rgb );
			} else {
				return $rgb;
			}
		}

		public static function isColorDark( $color ) {
			if ( empty( $color ) ) {
				return true;
			}
			$rgb      = self::hexToRGB( $color, false );
			$darkness = 1 - ( 0.299 * (float) $rgb[0] + 0.587 * (float) $rgb[1] + 0.114 * (float) $rgb[2] ) / 255;
			if ( $darkness < 0.5 ) {
				return false; // It's a light color
			} else {
				return true; // It's a dark color
			}
		}
	}
endif;
