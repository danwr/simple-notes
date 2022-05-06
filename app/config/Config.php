<?

namespace config;

class Config
{
    private $ini;
    
    public function __construct()
    {
        $this->ini = parse_ini_file(dirname(__DIR__) . '/app.ini');
    }
    
    public function value($name)
    {
        return $this->ini[$name];
    }
}

?>
