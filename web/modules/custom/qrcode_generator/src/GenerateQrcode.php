<?php

namespace Drupal\qrcode_generator;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

/**
 * Service description.
 */

class GenerateQrcode
{

    /**
     * The logger channel factory.
     *
     * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
     */
    protected $logger;

    /**
     * The file handler.
     *
     * @var \Drupal\Core\File\FileSystemInterface
     */
    protected $fileSystem;

    /**
     * Constructs a GenerateQrcode object.
     *
     * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
     *   The logger channel factory.
     * @param \Drupal\Core\File\FileSystemInterface $file_system
     *   The file handler.
     */
    public function __construct(LoggerChannelFactoryInterface $logger, FileSystemInterface $file_system) {
        $this->logger = $logger;
        $this->fileSystem = $file_system;
    }

    /**
     * Method description.
     */
    public function buildQrCode($url, $name)
    {

        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($url)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));


        $result = $writer->write($qrCode);
        $filename = str_replace(' ', '-', $name);
        $filename = $filename . rand() . '-qrcode.png';
        // Save it to a file in public file folder
        $directory = 'public://';
        $result->saveToFile($directory . $filename);

        return $filename;
    }

}
