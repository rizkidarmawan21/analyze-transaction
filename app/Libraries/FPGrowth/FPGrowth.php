<?php

declare(strict_types=1);

namespace App\Libraries\FPGrowth;

use drupol\phpermutations\Generators\Combinations;

class FPGrowth
{
    /**
     * Support threshold adalah nilai minimum support yang harus dipenuhi oleh itemset agar dianggap sering muncul.
     * Confidence threshold adalah nilai minimum confidence yang harus dipenuhi oleh rule agar dianggap kuat. Ini berupa nilai antara 0 dan 1. 1 Artinya 100%. 
     * Semakin tinggi nilai confidence, semakin kuat rule tersebut.
     * 
     * Kenapa di set 3 dan 0.7? Karena itu adalah nilai default yang sering digunakan dari algoritma FPGrowth.
    */
    protected int $support = 3;
    protected float $confidence = 0.7;

    private $patterns;
    private $rules;


    
    /**
     * @return int
     * 
     * Fungsi ini untuk mengembalikan nilai support
     */
    public function getSupport(): int
    {
        return $this->support;
    }

    /**
     * @param int $support
     * @return self
     * 
     * Fungsi ini untuk mengatur nilai support
     */
    public function setSupport(int $support): self
    {
        $this->support = $support;
        return $this;
    }

    /**
     * @return float
     * 
     * Fungsi ini untuk mengembalikan nilai confidence
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @param float $confidence
     * @return self
     * 
     * Fungsi ini untuk mengatur nilai confidence
     */
    public function setConfidence(float $confidence): self
    {
        $this->confidence = $confidence;
        return $this;
    }

    /**
     * @return mixed
     * 
     * Fungsi ini untuk mengembalikan pola yang sering muncul
     */
    public function getPatterns()
    {
        return $this->patterns;
    }

    /**
     * @return mixed
     * 
     * Fungsi ini untuk mengembalikan rule yang sering muncul
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * FPGrowth constructor.
     * @param int $support 1, 2, 3 ...
     * @param float $confidence 0 ... 1
     * 
     * Fungsi ini untuk mengatur nilai support dan confidence
     */
    public function __construct(int $support, float $confidence)
    {
        $this->setSupport($support);
        $this->setConfidence($confidence);
    }

    /**
     * Do algorithm
     * @param array $transactions
     * 
     * Fungsi ini untuk menjalankan algoritma FP-Growth
     * findFrequentPatterns digunakan untuk mencari pola yang sering muncul
     * generateAssociationRules digunakan untuk menghasilkan rule yang sering muncul
     */
    public function run(array $transactions)
    {
        $this->patterns = $this->findFrequentPatterns($transactions);
        $this->rules = $this->generateAssociationRules($this->patterns);
    }

    /**
     * @param array $transactions
     * @return array<string,int>
     * 
     * Fungsi ini untuk mencari pola yang sering muncul
     * FPTree adalah class yang digunakan untuk membuat tree dari transactions
     * minePatterns adalah fungsi yang digunakan untuk mencari pola yang sering muncul
     * yang dimaksud tree dari transactions adalah data yang sudah diurutkan berdasarkan support
     */
    protected function findFrequentPatterns(array $transactions): array
    {
        $tree = new FPTree($transactions, $this->support, null, 0);
        return $tree->minePatterns($this->support);
    }

    /**
     * @param array $patterns
     * @return array
     * 
     * Fungsi ini untuk menghasilkan rule yang sering muncul
     * Combinations adalah class yang digunakan untuk menghasilkan kombinasi dari itemset
     * confidence adalah nilai yang digunakan untuk mengukur seberapa kuat rule tersebut
     * jika confidence lebih besar dari nilai confidence yang sudah ditentukan, maka rule tersebut akan disimpan
     * 
     * Contoh:
     * Jika terdapat itemset {A, B, C} dan {A, B}, maka rule yang dihasilkan adalah {A, B} => {C}
     * Jika support dari {A, B, C} adalah 10 dan support dari {A, B} adalah 20, maka confidence dari rule tersebut adalah 10/20 = 0.5
     * Jika nilai confidence lebih besar dari nilai confidence yang sudah ditentukan, maka rule tersebut akan disimpan
     */
    protected function generateAssociationRules(array $patterns): array
    {
        $rules = [];
        foreach (array_keys($patterns) as $pattern) {
            $itemSet = explode(',', $pattern);
            $upperSupport = $patterns[$pattern];
            for ($i = 1; $i < count($itemSet); $i++) {
                $combinations = new Combinations($itemSet, $i);
                foreach ($combinations->generator() as $antecedent) {
                    sort($antecedent);
                    $antecedentStr = implode(',', $antecedent);
                    $consequent = array_diff($itemSet, $antecedent);
                    sort($consequent);
                    $consequentStr = implode(',', $consequent);
                    if (isset($patterns[$antecedentStr])) {
                        $lowerSupport = $patterns[$antecedentStr];
                        $confidence = floatval($upperSupport) / $lowerSupport;
                        if ($confidence >= $this->confidence) {
                            $rules[] = [$antecedentStr, $consequentStr, $confidence];
                        }
                    }
                }
            }
        }
        return $rules;
    }
}