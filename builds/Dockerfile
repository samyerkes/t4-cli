FROM php:7.3-cli-alpine

RUN $(php -r '$extensionInstalled = array_map("strtolower", \get_loaded_extensions(false));$requiredExtensions = ["zlib", "json", "json", "json", "json", "json", "json", "json", "json", "json", "json", "openssl", "openssl", "pcre", "pcre", "fileinfo", "fileinfo"];$extensionsToInstall = array_diff($requiredExtensions, $extensionInstalled);if ([] !== $extensionsToInstall) {echo \sprintf("docker-php-ext-install %s", implode(" ", $extensionsToInstall));}echo "echo \"No extensions\"";')

COPY t4 /t4

ENTRYPOINT ["/t4"]
