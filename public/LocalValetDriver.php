<?php

class LocalValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return void
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath . '/')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath . $uri) &&
            !is_dir($sitePath . $uri) &&
            pathinfo($sitePath . $uri)['extension'] != 'php') {
            return $sitePath . $uri;

        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {

        $_SERVER['PHP_SELF']    = $uri;
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];

        if (strpos($uri, '/') === 0) {
            //echo $uri;
            //die($_SERVER['QUERY_STRING']);
            // die($sitePath.'/api/index.php'.$uri);
            //return $sitePath.'/api/index.php'.$uri;
            //return $sitePath.'/api/index.php' . '?' . $_SERVER['QUERY_STRING'];
            $_SERVER['QUERY_STRING'] = substr($uri, 1);;
            return $sitePath.'/index.php';
        }

        $dynamicCandidates = [
            $this->asActualFile($sitePath, $uri),
            $this->asPhpIndexFileInDirectory($sitePath, $uri),
            $this->asHtmlIndexFileInDirectory($sitePath, $uri),
        ];

        foreach ($dynamicCandidates as $candidate) {
            if ($this->isActualFile($candidate)) {
                $_SERVER['SCRIPT_FILENAME'] = $candidate;
                $_SERVER['SCRIPT_NAME'] = str_replace($sitePath, '', $candidate);
                $_SERVER['DOCUMENT_ROOT'] = $sitePath;
                return $candidate;
            }
        }

        $fixedCandidatesAndDocroots = [
            $this->asRootPhpIndexFile($sitePath) => $sitePath,
            $this->asPublicPhpIndexFile($sitePath) => $sitePath . '/public',
            $this->asPublicHtmlIndexFile($sitePath) => $sitePath . '/public',
        ];

        foreach ($fixedCandidatesAndDocroots as $candidate => $docroot) {
            if ($this->isActualFile($candidate)) {
                $_SERVER['SCRIPT_FILENAME'] = $candidate;
                $_SERVER['SCRIPT_NAME'] = '/index.php';
                $_SERVER['DOCUMENT_ROOT'] = $docroot;
                return $candidate;
            }
        }
    }
}