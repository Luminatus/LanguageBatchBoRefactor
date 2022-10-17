<?php

namespace Language;

use Language\Api\Response\ApiErrorInterface;
use Language\Api\Response\ApiResponseInterface;
use Language\Api\SystemApi;
use Language\Exception\AppletLanguageFileApiException;
use Language\Exception\AppletLanguagesApiException;
use Language\Exception\LanguageFileApiException;
use Language\File\FileType;
use Language\File\PathBuilder;
use Language\File\PathWriter;
use Language\File\WriterInterface;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/**
	 * Contains the applications which ones require translations.
	 *
	 * @var array
	 */
	protected static $applications = [];

	/**
	 * Starts the language file generation.
	 *
	 * @throws Exception
	 * @return void
	 */
	public static function generateLanguageFiles()
	{
		// The applications where we need to translate.
		self::$applications = Config::get('system.translated_applications');

		echo "\nGenerating language files\n";
		foreach (self::$applications as $application => $languages) {
			echo "[APPLICATION: " . $application . "]\n";
			foreach ($languages as $language) {
				echo "\t[LANGUAGE: " . $language . "]";
				if (self::getLanguageFile($application, $language)) {
					echo " OK\n";
				} else {
					throw new \Exception('Unable to generate language file!');
				}
			}
		}
	}

	/**
	 * Gets the language file for the given language and stores it.
	 *
	 * @param string $application   The name of the application.
	 * @param string $language      The identifier of the language.
	 *
	 * @throws CurlException   If there was an error during the download of the language file.
	 * @throws LanguageFileApiException
	 *
	 * @return bool   The success of the operation.
	 */
	protected static function getLanguageFile($application, $language)
	{
		$result = false;
		$languageResponse = SystemApi::getLanguageFile($language);

		if ($languageResponse instanceof ApiErrorInterface) {
			throw new LanguageFileApiException($application, $language, $languageResponse);
		}

		// If we got correct data we store it.
		$pathBuilder = PathBuilder::cache()->dir($application)->file($language, FileType::EXTENSIONS[$languageResponse->getType()]);
		// If there is no folder yet, we'll create it.
		$pathWriter = new PathWriter($pathBuilder);
		$pathWriter->setFlags(WriterInterface::FLAG_GENERATE_DIRECTORIES | WriterInterface::FLAG_OVERWRITE);

		$result = $pathWriter->write($languageResponse->getContent());

		return (bool)$result;
	}

	/**
	 * Gets the language files for the applet and puts them into the cache.
	 *
	 * @throws Exception   If there was an error.
	 *
	 * @return void
	 */
	public static function generateAppletLanguageXmlFiles()
	{
		// List of the applets [directory => applet_id].
		$applets = static::getAppletList();

		echo "\nGetting applet language XMLs..\n";

		foreach ($applets as $appletDirectory => $appletLanguageId) {
			echo " Getting > $appletLanguageId ($appletDirectory) language xmls..\n";
			$languages = self::getAppletLanguages($appletLanguageId);
			if (empty($languages->getContent())) {
				throw new \Exception("There is no available languages for the $appletLanguageId applet.");
			} else {
				echo ' - Available languages: ' . implode(', ', $languages->getContent()) . "\n";
			}

			$pathBuilder = PathBuilder::cache()->dir('flash');
			$pathWriter = new PathWriter($pathBuilder);
			$pathWriter->setFlags(WriterInterface::FLAG_OVERWRITE, WriterInterface::FLAG_CHECK_LENGTH);

			foreach ($languages as $language) {
				$languageFile = self::getAppletLanguageFile($appletLanguageId, $language);
				$pathBuilder->file("lang_$language", FileType::EXTENSIONS[$languageFile->getType()]);

				if ($pathWriter->write($languageFile->getContent())) {
					echo "OK saving {$pathBuilder->getPath()} was successful.\n";
				} else {
					throw new \Exception("Unable to save applet: ($appletLanguageId) language: ($language) xml ({$pathBuilder->getPath()})!");
				}
			}
			echo " < $appletLanguageId ($appletDirectory) language xml cached.\n";
		}

		echo "\nApplet language XMLs generated.\n";
	}

	/**
	 * Gets the available languages for the given applet.
	 *
	 * @param string $applet   The applet identifier.
	 *
	 * @throws AppletLanguagesApiException
	 * 
	 * @return ApiResponseInterface The API response containing the list of the available applet languages.
	 */
	protected static function getAppletLanguages(string $applet): ApiResponseInterface
	{
		$result = SystemApi::getAppletLanguages($applet);

		if ($result instanceof ApiErrorInterface) {
			throw new AppletLanguagesApiException($applet, $result);
		}

		return $result;
	}


	/**
	 * Gets a language xml for an applet.
	 *
	 * @param string $applet      The identifier of the applet.
	 * @param string $language    The language identifier.
	 * 
	 * @throws AppletLanguageFileApiException
	 *
	 * @return ApiResponseInterface  The API response with the content of the language file or an error response if weren't able to get it.
	 */
	protected static function getAppletLanguageFile($applet, $language)
	{
		$result = SystemApi::getAppletLanguageFile($applet, $language);

		if ($result instanceof ApiErrorInterface) {
			throw new AppletLanguageFileApiException($applet, $language, $result);
		}

		return $result;
	}

	/**
	 * Gets the list of applets
	 *
	 * @return array  The list of available applets
	 */
	protected static function getAppletList(): array
	{
		return [
			'memberapplet' => 'JSM2_MemberApplet',
		];
	}
}
