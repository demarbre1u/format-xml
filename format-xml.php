<?php 

class FormatXMLCommand {
    /**
     * The arguments passed to the script
     */
    private array $args;
    
    /**
     * The content of the XML file to format
     */
    private string $file_content;
    
    /**
     * The available options of the script
     */
    private array $options_array = [
        'help' => ['-h', '--help']
    ];

    public function __construct($args) {
        $this->args = $args;
    }

    /**
     * The main function that runs the script
     */
    public function run(): void {
        if(! $this->isFromCmdLine()) {
            echo "Error: this tool is meant to be used in a terminal";
            $this->printHelp();
            exit(1);
        }

        if(! $this->isCmdValid()) {
            exit(1);
        }

        $this->loadFileContent();
        $this->formatFileContent();
    }

    /**
     * Prints the help text
     */
    private function printHelp(): void {
        echo PHP_EOL . "This command line tool is meant to strip ' <![CDATA[ ... ]]> ' from an XML file." . PHP_EOL;
        echo "It prints the result in the standard output." . PHP_EOL . PHP_EOL;

        echo "Usage: php format-xml.php [options] [filename]" . PHP_EOL;
        echo "\t--help, -h : displays this text" . PHP_EOL;
        echo "\tfilename : the file containing the XML to format" . PHP_EOL . PHP_EOL;
    }

    /**
     * Returns whether or not the script is being ran from the command line
     * 
     * @return bool
     */
    private function isFromCmdLine(): bool {
        return php_sapi_name() === 'cli';
    }

    /**
     * Returns whether the command is valid
     * 
     * @return true
     */
    private function isCmdValid(): bool {
        // Checks the number of arguments
        if(count($this->args) !== 2) {
            echo "Error: the number of argument is invalid" . PHP_EOL;
            $this->printHelp();
            return false;
        }

        // Checks if an help option is present
        if(in_array($this->args[1], $this->options_array['help'])) {
            $this->printHelp();
            return true;
        }

        // Checks if the 1st argument is a valid file
        if(! is_file($this->args[1])) {
            echo "Error: '{$this->args[1]}' is not a valid file" . PHP_EOL;
            $this->printHelp();
            return false;  
        }

        return true;
    }

    /**
     * Loads the content of the file
     */
    private function loadFileContent(): void {
        $this->file_content = file_get_contents($this->args[1]);
    }

    /**
     * Formats the loaded content of the file
     */
    private function formatFileContent(): void {
        $pattern = '/\s*\n*<!\[CDATA\[(.*)\]\]>\s*\n*/u';
        $replacement = '$1';
        $subject = $this->file_content;

        $this->file_content = preg_replace($pattern, $replacement, $subject);

        print_r($this->file_content);
        echo PHP_EOL;
    } 
}

(new FormatXMLCommand($argv))->run();