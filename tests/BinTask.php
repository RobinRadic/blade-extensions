<?php


class BinTask extends ExecTask {

    /**
     * Main method: wraps execute() command.
     *
     * @return void
     */
    public function main()
    {
        if (!$this->isApplicable()) {
            return;
        }

        $this->prepare();
        $this->command = "php vendor/bin/" . $this->command;
        $this->buildCommand();

        list($return, $output) = $this->executeCommand();
        $this->cleanup($return, $output);
    }
}
