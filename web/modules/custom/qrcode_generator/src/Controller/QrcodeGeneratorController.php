<?php

namespace Drupal\qrcode_generator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Drupal\Core\File\FileSystemInterface;

/**
 * Returns responses for QRCode Generator routes.
 */
class QrcodeGeneratorController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build($url, $name) {

    $writer = new PngWriter();

  // Create QR code
  $qrCode = QrCode::create('Life is too short to be generating QR codes')
      ->setEncoding(new Encoding('UTF-8'))
      ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
      ->setSize(300)
      ->setMargin(10)
      ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
      ->setForegroundColor(new Color(0, 0, 0))
      ->setBackgroundColor(new Color(255, 255, 255));


    $result = $writer->write($qrCode);
    $filename = str_replace(' ', '-', $name);
    // Save it to a file
    $directory = 'public://Qr-codes/';
    $result->saveToFile($directory . $filename .'-qrcode.png');
    $build['content'] = [
      '#markup' => $filename . '-qrcode.png',
    ];
    return $build;
  }


}
