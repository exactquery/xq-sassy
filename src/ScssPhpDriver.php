<?php
/**
 * ScssPhpDriver.php
 */

namespace XQ\Drivers;

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Formatter\Compact;
use Leafo\ScssPhp\Formatter\Compressed;
use Leafo\ScssPhp\Formatter\Expanded;
use Leafo\ScssPhp\Formatter\Nested;

/**
 * Class ScssphpDriver
 * @package XQ\Drivers
 */
class ScssphpDriver extends AbstractSassDriver
{

  // region //////////////////////////////////////////////// Main Public Methods

  public function compile( $content )
  {
    if ( !empty( $content ) )
    {
      // Create the ProcessBuilder
      $sc = new Compiler();

      // Import Paths
      foreach ( $this->importPaths as $importPath )
      {
        $sc->addImportPath($importPath);
      }

      // Line Numbers
      if ( $this->lineNumbers )
      {
        $sc->setLineNumberStyle( Compiler::LINE_COMMENTS );
      }

      // Precision
      if ( $this->precision != self::DEFAULT_PRECISION )
      {
        $sc->setNumberPrecision( $this->precision );
      }

      // Output Style
      if ( $this->style != self::DEFAULT_STYLE )
      {
        switch ( $this->style )
        {
          case self::STYLE_NESTED:
            $sc->setFormatter(Nested::class);
            break;
          case self::STYLE_EXPANDED:
            $sc->setFormatter(Expanded::class);
            break;
          case self::STYLE_COMPACT:
            $sc->setFormatter(Compact::class);
            break;
          case self::STYLE_COMPRESSED:
            $sc->setFormatter(Compressed::class);
            break;
          default:
            $sc->setFormatter(Nested::class);
            break;
        }
      }

      $output = $sc->compile($content);
    }

    return (isset($output)) ? $output : null;
  }

  public function addPluginPath( $path, $prepend = false )
  {
    throw new \Exception( 'The Leafo scssphp package does not support setting a plugin path.' );
  }

  public function setPluginPaths( array $paths )
  {
    $this->addPluginPath( $paths );
  }

  public function setMapComment( bool $mapComment )
  {
    throw new \Exception( 'The Leafo scssphp package does not support omitting map comments or source maps.' );
  }

  public function setSourceMap( bool $sourceMap )
  {
    throw new \Exception( 'The Leafo scssphp package does not support the generation of source maps.' );
  }

  // endregion ///////////////////////////////////////////// End Main Public Methods
}
