<?php
/**
 * Apriori Algorithm - الگوریتم اپریوری
 * PHP Version 5.0.0
 * Version 0.1 Beta
 * @link http://vtwo.org
 * @author VTwo Group (info@vtwo.org)
 * @license GNU GENERAL PUBLIC LICENSE
 *
 *
 * '-)
 */
namespace App\Http\Controllers;

use App\Helpers\AlgoritmaApriori;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        return view('laporan.index');
    }

    public function result()
    {
        $apriori = new AlgoritmaApriori();

        $apriori->setMaxScan(100); //Scan 2, 3, ...
        $apriori->setMinSup(2); //Minimum support 1, 2, 3, ...
        $apriori->setMinConf(75); //Minimum confidence - Percent 1, 2, ..., 100
        $apriori->setDelimiter('-'); //Delimiter

        $dataset = array();
        $dataset[] = array('A', 'B', 'C', 'D');
        $dataset[] = array('A', 'D', 'C');
        $dataset[] = array('B', 'C');
        $dataset[] = array('A', 'E', 'C');

        $dataset = [
            // [1, 2, 3, 4, 5],          // Transaksi 1
            // [2, 3, 5, 6, 7],          // Transaksi 2
            // [1, 2, 3, 4, 6],          // Transaksi 3
            // [1, 3, 5, 8, 9],          // Transaksi 4
            // [2, 3, 5, 7, 8],          // Transaksi 5
            // [1, 3, 5, 6, 9],          // Transaksi 6
            // [1, 2, 3, 6, 8],          // Transaksi 7
            // [1, 2, 3, 5, 7],          // Transaksi 8
            // [1, 2, 4, 6, 8],          // Transaksi 9
            // [1, 3, 5, 7, 9],          // Transaksi 10
            ['beras', 'susu', 'telur', 'ikan'],
            ['beras', 'telur'],
            ['beras', 'ikan', 'telur'],
            ['coklat', 'susu', 'telur'],
            ['beras', 'coklat', 'susu', 'ikan'],
            ['coklat', 'susu'],
            // ... dan seterusnya
        ];

        $apriori->process($dataset);

        echo '<h1>Datasets</h1>';
        dump($dataset);
        //Frequent Itemsets
        echo '<h1>Frequent Itemsets</h1>';
        $apriori->printFreqItemsets();

        echo '<h3>Frequent Itemsets Array</h3>';
        dump($apriori->getFreqItemsets());

        //Association Rules
        echo '<h1>Association Rules</h1>';
        $apriori->printAssociationRules();

        echo '<h3>Association Rules Array</h3>';
        dump($apriori->getAssociationRules());

        // //Save to file
        // $apriori->saveFreqItemsets('freqItemsets.txt');
        // $apriori->saveAssociationRules('associationRules.txt');
    }
}
