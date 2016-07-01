<?php

use Illuminate\Database\Seeder;
use App\Escola;

class Escolas extends Seeder {

    public $etecs = ['ETEC ABDIAS DO NASCIMENTO', 'ETEC ADOLPHO BEZERIN', 'ETEC ALCIDES CESTARI', 'ETEC AMIM JUNDI', 'ETEC ANGELO CAVALHEIRO', 'ETEC ANTONIO DEVISATE', 'ETEC ARISTÓTELES FERREIRA', 'ETEC ARNALDO PEREIRA CHEREGATTI', 'ETEC ASTOR DE MATTOS CARVALHO', 'ETEC AUGUSTO TORTOLERO ARAÚJO', 'ETEC BARTOLOMEU DA SILVA', 'ETEC BENEDITO STORANI', 'ETEC BENTO CARLOS BOTELHO DO AMARAL', 'ETEC BENTO QUIRINO', 'ETEC CARAPICUÍBA', 'ETEC CEPAM', 'ETEC CIDADE DO LIVRO', 'ETEC COMENDADOR JOÃO RAYS', 'ETEC CÔNEGO JOSÉ BENTO', 'ETEC CORONEL FERNANDO FEBELIANO DA COSTA', 'ETEC CORONEL RAPHAEL BRANDÃO', 'ETEC DARCY PEREIRA DE MORAES', 'ETEC DE APIAÍ', 'ETEC DE ARAÇATUBA', 'ETEC DE ARTES', 'ETEC DE BARUERI', 'ETEC DE CAIEIRAS', 'ETEC DE CAMPO LIMPO PAULISTA', 'ETEC DE CARAGUATATUBA', 'ETEC DE CERQUILHO', 'ETEC DE CIDADE TIRADENTES', 'ETEC DE COTIA', 'ETEC DE CUBATÃO', 'ETEC DE EMBU', 'ETEC DE ESPORTES', 'ETEC DE FERNANDÓPOLIS', 'ETEC DE FERRAZ DE VASCONCELOS', 'ETEC DE GUAIANAZES', 'ETEC DE HORTOLÂNDIA', 'ETEC DE IBATÉ', 'ETEC DE IBITINGA', 'ETEC DE ILHA SOLTEIRA', 'ETEC DE ITANHAÉM', 'ETEC DE ITAQUAQUECETUBA', 'ETEC DE ITAQUERA', 'ETEC DE ITARARÉ', 'ETEC DE LINS', 'ETEC DE MAUÁ', 'ETEC DE MONTE MOR', 'ETEC DE NOVA ODESSA', 'ETEC DE OLIMPIA', 'ETEC DE PERUÍBE', 'ETEC DE PIEDADE', 'ETEC DE POÁ', 'ETEC DE SANTA FÉ DO SUL', 'ETEC DE SÃO JOSÉ DO RIO PARDO', 'ETEC DE SÃO ROQUE', 'ETEC DE SÃO SEBASTIÃO', 'ETEC DE SUZANO', 'ETEC DE VARGEM GRANDE DO SUL', 'ETEC DE VILA FORMOSA', 'ETEC DEP. ARY DE CAMARGO PEDROSO', 'ETEC DEP. FRANCISCO FRANCO', 'ETEC DEPUTADO PAULO ORNELLAS CARVALHO DE BARROS', 'ETEC DEPUTADO SALIM SEDEH', 'ETEC DONA ESCOLÁSTICA ROSA', 'ETEC DONA SEBASTIANA DE BARROS', 'ETEC DOUTOR ADAIL NUNES DA SILVA', 'ETEC DOUTOR FRANCISCO NOGUEIRA DE LIMA', 'ETEC DOUTOR GERALDO JOSÉ RODRIGUES ALCKMIN', 'ETEC DOUTOR JÚLIO CARDOSO', 'ETEC DOUTOR RENATO CORDEIRO', 'ETEC DOUTORA MARIA AUGUSTA SARAIVA', 'ETEC DOUTORA RUTH CARDOSO', 'ETEC DR EMILIO HERNANDEZ AGUILAR', 'ETEC DR. CAROLINO DA MOTTA E SILVA', 'ETEC DR. JOSÉ LUIZ VIANA COUTINHO', 'ETEC DR. LUIZ CÉSAR COUTO', 'ETEC ELIAS NECHAR', 'ETEC EUDÉCIO LUIZ VICENTE', 'ETEC EURO ALBINO DE SOUZA', 'ETEC FERNANDO PRESTES', 'ETEC FRANCISCO GARCIA', 'ETEC FRANCISCO MORATO', 'ETEC FREI ARNALDO MARIA DE ITAPORANGA', 'ETEC GETÚLIO VARGAS', 'ETEC GILDO MARÇAL BEZERRA BRANDÃO', 'ETEC GINO REZAGHI', 'ETEC GUSTAVO TEIXEIRA', 'ETEC IRMÃ AGOSTINA', 'ETEC ITAQUERA II', 'ETEC JACINTO FERREIRA DE SÁ', 'ETEC JARAGUÁ', 'ETEC JARDIM ÂNGELA', 'ETEC JOÃO BAPTISTA DE LIMA FIGUEIREDO', 'ETEC JOÃO BELARMINO', 'ETEC JOÃO GOMES DE ARAÚJO', 'ETEC JOÃO JORGE GERAISSATE', 'ETEC JOAQUIM FERREIRA DO AMARAL', 'ETEC JORGE STREET', 'ETEC JORNALISTA ROBERTO MARINHO', 'ETEC JOSÉ MARTIMIANO DA SILVA', 'ETEC JOSÉ ROCHA MENDES', 'ETEC JÚLIO DE MESQUITA', 'ETEC JUSCELINO KUBITSCHEK DE OLIVEIRA', 'ETEC LAURINDO ALVES DE QUEIROZ', 'ETEC MACHADO DE ASSIS', 'ETEC MANDAQUI', 'ETEC MANOEL DOS REIS ARAÚJO', 'ETEC MARTINHO DI CIERO', 'ETEC MONSENHOR ANTÔNIO MAGLIANO', 'ETEC ORLANDO QUAGLIATO', 'ETEC OSASCO II', 'ETEC PADRE CARLOS LEONCIO DA SILVA', 'ETEC PARQUE BELEM', 'ETEC PARQUE DA JUVENTUDE', 'ETEC PAULINO BOTELHO ', 'ETEC PAULISTANO', 'ETEC PAULO GUERREIRO FRANCO', 'ETEC PEDRO BADRAN', 'ETEC PEDRO D` ARCÁDIA NETO ', 'ETEC PEDRO FERREIRA ALVES', 'ETEC PHILADELPHO GOUVÊA NETTO', 'ETEC POLIVALENTE DE AMERICANA', 'ETEC PREFEITO ALBERTO FERES', 'ETEC PREFEITO JOSÉ ESTEVES', 'ETEC PRESIDENTE VARGAS', 'ETEC PROF PEDRO LEME BRISOLLA SOBRINHO', 'ETEC PROF. ALCÍDIO DE SOUZA PRADO', 'ETEC PROF. ANNA DE OLIVEIRA FERRAZ', 'ETEC PROF. DR. ANTONIO EUFRÁSIO TOLEDO', 'ETEC PROF. DR. SYLVIO DE MATTOS CARVALHO', 'ETEC PROF. DRª DOROTI Q.K.TOYOHARA', 'ETEC PROF. JADYR SALLES', 'ETEC PROF. JOSÉ IGNÁCIO DE AZEVEDO FILHO', 'ETEC PROF. URIAS FERREIRA', 'ETEC PROF.A HELCY M. MARTINS AGUIAR', 'ETEC PROFA ILZA NASCIMENTO PINTUS', 'ETEC PROFA MARIA CRISTINA MEDEIROS', 'ETEC PROFESSOR ADOLPHO ARRUDA MELLO', 'ETEC PROFESSOR ALFREDO DE BARROS SANTOS', 'ETEC PROFESSOR APRÍGIO GONZAGA', 'ETEC PROFESSOR ARMANDO BAYEUX DA SILVA', 'ETEC PROFESSOR BASILIDES DE GODOY', 'ETEC PROFESSOR CAMARGO ARANHA', 'ETEC PROFESSOR CARMINE BIAGIO TUNDISI', 'ETEC PROFESSOR DR. JOSÉ DAGNONI', 'ETEC PROFESSOR IDIO ZUCCHI', 'ETEC PROFESSOR JOSÉ SANT\'ANA DE CASTRO', 'ETEC PROFESSOR LUIZ PIRES BARBOSA', 'ETEC PROFESSOR MARCOS UCHÔAS DOS SANTOS PENCHEL', 'ETEC PROFESSOR MÁRIO ANTONIO VERZA', 'ETEC PROFESSOR MATHEUS LEITE DE ABREU', 'ETEC PROFESSOR MILTON GAZZETTI', 'ETEC PROFESSORA CARMELINA BARBOSA', 'ETEC PROFESSORA LUZIA MARIA MACHADO', 'ETEC PROFESSORA MARINES TEODORO DE FREITAS ALMEIDA', 'ETEC PROFESSORA NAIR LUCCAS RIBEIRO', 'ETEC PROFº ADHEMAR BATISTA HEMÉRITAS', 'ETEC RAPOSO TAVARES', 'ETEC ROSA PERRONE SCAVONE DE ITATIBA', 'ETEC RUBENS DE FARIA E SOUZA', 'ETEC SALES GOMES', 'ETEC SANTA IFIGÊNIA', 'ETEC SANTA ISABEL', 'ETEC SANTA ROSA DE VITERBO', 'ETEC SÃO MATEUS', 'ETEC SAPOPEMBA', 'ETEC SEBASTIANA AUGUSTA DE MORAES', 'ETEC TAKASHI MORITA', 'ETEC TENENTE AVIADOR GUSTAVO KLUG', 'ETEC TEREZA APARECIDA CARDOSO NUNES DE OLIVEIRA', 'ETEC TIQUATIRA', 'ETEC TRAJANO CAMARGO', 'ETEC UIRAPURU', 'ETEC VASCO A. VENCHIARUTTI', 'ETEC ZONA LESTE', 'ETEC ZONA SUL'];

    public function run() {
        foreach ($this->etecs as $etec) {
            if (Escola::select('nome')->where('nome', $etec)->first() == null) {
                $escola = new Escola;
                $escola->nome = $etec;
                $escola->cod_prof = $this->getRandomNumbers(1, 100000, 499999, false, true)[0];
                $escola->cod_coord = $this->getRandomNumbers(1, 500000, 999999, false, true)[0];

                $escola->save() ? $this->command->info(e($etec) . " adicionada.") : 'Erro ao adicionar a ' . $etec;
            }
        }
    }

    function getRandomNumbers($num, $min, $max, $repeat = false) {
        if ((($max - $min) + 1) >= $num) {
            $n = array();
            while (count($n) < $num) {
                $number = mt_rand($min, $max);

                if ($repeat || !in_array($number, $n)) {
                    $n[] = $number;
                }
            }
            return $n;
        }
        return false;
    }

}
