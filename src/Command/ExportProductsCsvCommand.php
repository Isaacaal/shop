<?php
namespace App\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:export:products-csv', description: 'Exporte tous les produits en CSV')]
class ExportProductsCsvCommand extends Command
{
    public function __construct(private ProductRepository $repo) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = sprintf('%s/var/export/products_%s.csv', $this->getApplication()->getKernel()->getProjectDir(), date('Ymd_His'));
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
        $f = fopen($filename, 'w');

        fputcsv($f, ['id','name','description','price','slug','image'], ';');

        foreach ($this->repo->findAll() as $p) {
            fputcsv($f, [
                $p->getId(),
                $p->getName(),
                $p->getDescription(),
                $p->getPrice(),
                $p->getSlug(),
                $p->getImage()
            ], ';');
        }
        fclose($f);

        $output->writeln("<info>Exporté: $filename</info>");
        return Command::SUCCESS;
    }

}
