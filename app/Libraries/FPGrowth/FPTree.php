<?php

declare(strict_types=1);

namespace App\Libraries\FPGrowth;

use drupol\phpermutations\Generators\Combinations;

class FPTree
{
    /** @var array<string,int> */
    private array $frequent;

    /** @var array<string,FPNode> */
    private array $headers;

    private FPNode $root;

    /**
     * Initialize the tree.
     * @param array $transactions
     * @param int $threshold
     * @param $rootValue
     * @param int $rootCount
     * 
     * transactions adalah array yang berisi itemset yang akan dijadikan sebagai input algoritma FPGrowth.
     * threshold adalah nilai minimum support yang harus dipenuhi oleh itemset agar dianggap sering muncul.
     * rootValue adalah nilai root node dari FP Tree.
     * rootCount adalah nilai count dari root node dari FP Tree.
     * 
     * Lalu kita panggil method findFrequentItems, buildHeaderTable, dan buildFPTree.
     * 
     * findFrequentItems digunakan untuk membuat dictionary dari itemset yang sering muncul.
     * buildHeaderTable digunakan untuk membuat header table. apa itu header table? Header table adalah struktur data yang digunakan untuk menyimpan node yang sama dalam FP Tree.
     * buildFPTree digunakan untuk membuat FP Tree.
     * 
     * Lalu kita inisialisasi property frequent, headers, dan root.
     */
    public function __construct(array $transactions, int $threshold, $rootValue, int $rootCount)
    {
        $this->frequent = $this->findFrequentItems($transactions, $threshold);
        $this->headers = $this->buildHeaderTable();
        $this->root = $this->buildFPTree($transactions, $rootValue, $rootCount, $this->frequent);
    }

    /**
     * Create a dictionary of items with occurrences above the threshold.
     * @param array $transactions
     * @param int $threshold
     * @return array<string,int>
     * 
     * Fungsi ini digunakan untuk membuat dictionary dari itemset yang sering muncul. apa itu dictionary? Dictionary adalah struktur data yang digunakan untuk menyimpan data dalam bentuk key-value pair.
     */
    protected function findFrequentItems(array $transactions, int $threshold): array
    {
        $frequentItems = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $item) {
                if (array_key_exists($item, $frequentItems)) {
                    $frequentItems[$item] += 1;
                } else {
                    $frequentItems[$item] = 1;
                }
            }
        }

        foreach (array_keys($frequentItems) as $key) {
            if ($frequentItems[$key] < $threshold) {
                unset($frequentItems[$key]);
            }
        }

        arsort($frequentItems);
        return $frequentItems;
    }

    /**
     * Build the header table.
     * @return array<string,null|FPNode>
     * 
     * Fungsi ini digunakan untuk membuat header table. apa itu header table? Header table adalah struktur data yang digunakan untuk menyimpan node yang sama dalam FP Tree.
     * ini fungsinya buat apa? Header table digunakan untuk menyimpan node yang sama dalam FP Tree.
     */
    protected function buildHeaderTable(): array
    {
        $headers = [];
        foreach (array_keys($this->frequent) as $key) {
            $headers[$key] = null;
        }
        return $headers;
    }

    /**
     * Build the FP tree and return the root node.
     * @param $transactions
     * @param $rootValue
     * @param $rootCount
     * @param $frequent
     * @return FPNode
     * 
     * Fungsi ini digunakan untuk membuat FP Tree. apa itu FP Tree? FP Tree adalah struktur data yang digunakan untuk menyimpan itemset yang sering muncul.
     * 
     */
    protected function buildFPTree($transactions, $rootValue, $rootCount, &$frequent): FPNode
    {
        $root = new FPNode($rootValue, $rootCount, null);
        arsort($frequent);
        foreach ($transactions as $transaction) {
            $sortedItems = [];
            foreach ($transaction as $item) {
                if (isset($frequent[$item])) {
                    $sortedItems[] = $item;
                }
            }

            usort($sortedItems, function ($a, $b) use ($frequent) {
                return $frequent[$b] <=> $frequent[$a];
            });

            if (count($sortedItems) > 0) {
                $this->insertTree($sortedItems, $root);
            }
        }
        return $root;
    }

    /**
     * Recursively grow FP tree.
     * @param array $items
     * @param FPNode $node
     * 
     * Fungsi ini digunakan untuk menambahkan itemset ke FP Tree.
     * getChild digunakan untuk mendapatkan child dari node. 
     */
    protected function insertTree(array $items, FPNode $node): void
    {
        $first = $items[0];
        $child = $node->getChild($first);

        if ($child !== null) {
            $child->count += 1;
        } else {
            // Add new child
            $child = $node->addChild($first);
            // Link it to header structure.
            if ($this->headers[$first] === null) {
                $this->headers[$first] = $child;
            } else {
                $current = $this->headers[$first];
                while ($current->link !== null) {
                    $current = $current->link;
                }
                $current->link = $child;
            }
        }

        // Call function recursively.
        $remainingItems = array_slice($items, 1, null);

        if (count($remainingItems) > 0) {
            $this->insertTree($remainingItems, $child);
        }
    }

    /**
     * If there is a single path in the tree,
     * return true, else return false.
     * @param FPNode $node
     * @return bool
     * 
     * Fungsi ini digunakan untuk mengecek apakah FP Tree memiliki single path atau tidak.
     */
    protected function treeHasSinglePath(FPNode $node): bool
    {
        $childrenCount = count($node->children);

        if ($childrenCount > 1) {
            return false;
        }

        if ($childrenCount === 0) {
            return true;
        }

        return $this->treeHasSinglePath(current($node->children));
    }

    /**
     * Mine the constructed FP tree for frequent patterns.
     * @param int $threshold
     * @return array<string,int>
     * 
     * Fungsi ini digunakan untuk mencari pola yang sering muncul.
     * minePatterns digunakan untuk mencari pola yang sering muncul.
     * zipPatterns digunakan untuk menambahkan suffix ke pola dalam dictionary jika kita berada dalam conditional FP tree.
     */
    public function minePatterns(int $threshold): array
    {
        if ($this->treeHasSinglePath($this->root)) {
            return $this->generatePatternList();
        }

        return $this->zipPatterns($this->mineSubTrees($threshold));
    }

    /**
     * Append suffix to patterns in dictionary if
     * we are in a conditional FP tree.
     * @param array $patterns
     * @return array<string,int>
     * 
     * Fungsi ini digunakan untuk menambahkan suffix ke pola dalam dictionary jika kita berada dalam conditional FP tree.
     * zipPatterns digunakan untuk menambahkan suffix ke pola dalam dictionary jika kita berada dalam conditional FP tree.
     * 
     * Lalu kita cek apakah root node dari FP Tree adalah null atau tidak.
     * Jika root node dari FP Tree adalah null, maka kita kembalikan pola yang sudah di zip.
     */
    protected function zipPatterns(array $patterns): array
    {
        if ($this->root->value === null) {
            return $patterns;
        }

        // We are in a conditional tree.
        $newPatterns = [];
        foreach (array_keys($patterns) as $strKey) {
            $key = explode(',', $strKey);
            $key[] = $this->root->value;
            sort($key);
            $newPatterns[implode(',', $key)] = $patterns[$strKey];
        }

        return $newPatterns;
    }

    /**
     * Generate a list of patterns with support counts.
     * @return array<string,int>
     * 
     * Fungsi ini digunakan untuk membuat list dari pola dengan support counts.
     * generatePatternList digunakan untuk membuat list dari pola dengan support counts.
     * 
     * Lalu kita inisialisasi variable patterns.
     * Lalu kita ambil item dari frequent.
     * 
     * Lalu kita cek apakah root node dari FP Tree adalah null atau tidak.
     * Jika root node dari FP Tree adalah null, maka kita kembalikan pola yang sudah di zip.
     * 
     */
    protected function generatePatternList(): array
    {
        $patterns = [];
        $items = array_keys($this->frequent);

        // If we are in a conditional tree, the suffix is a pattern on its own.
        if ($this->root->value !== null) {
            $patterns[$this->root->value] = $this->root->count;
        }

        for ($i = 1; $i <= count($items); $i++) {
            $combinations = new Combinations($items, $i);
            foreach ($combinations->generator() as $subset) {
                $pattern = $this->root->value !== null ? array_merge($subset, [$this->root->value]) : $subset;
                sort($pattern);
                $min = PHP_INT_MAX;
                /** @var string $x */
                foreach ($subset as $x) {
                    if ($this->frequent[$x] < $min) {
                        $min = $this->frequent[$x];
                    }
                }
                $patterns[implode(',', $pattern)] = $min;
            }
        }

        return $patterns;
    }

    /**
     * Generate subtrees and mine them for patterns.
     * @param int $threshold
     * @return array
     * 
     * Fungsi ini digunakan untuk membuat subtree dan mencari pola yang sering muncul.
     * mineSubTrees digunakan untuk membuat subtree dan mencari pola yang sering muncul.
     * 
     * Lalu kita inisialisasi variable patterns.
     * Lalu kita ambil frequent dan kita urutkan.
     * Lalu kita ambil key dari frequent.
     * 
     */
    protected function mineSubTrees(int $threshold): array
    {
        $patterns = [];
        $miningOrder = $this->frequent;
        asort($miningOrder);
        $miningOrder = array_keys($miningOrder);

        // Get items in tree in reverse order of occurrences.
        // Ambil item dalam tree dalam urutan terbalik dari kemunculan.
        foreach ($miningOrder as $item) {
            /** @var FPNode[] $suffixes */
            $suffixes = [];
            $conditionalTreeInput = [];
            $node = $this->headers[$item];

            // Follow node links to get a list of all occurrences of a certain item.
            // Ikuti tautan node untuk mendapatkan daftar semua kemunculan item tertentu.
            while ($node !== null) {
                $suffixes[] = $node;
                $node = $node->link;
            }

            // For each currence of the item, trace the path back to the root node.
            // 
            foreach ($suffixes as $suffix) {
                $frequency = $suffix->count;
                $path = [];
                $parent = $suffix->parent;
                while ($parent->parent !== null) {
                    $path[] = $parent->value;
                    $parent = $parent->parent;
                }
                for ($i = 0; $i < $frequency; $i++) {
                    $conditionalTreeInput[] = $path;
                }
            }

            // Now we have the input for a subtree, so construct it and grab the patterns.
            $subtree = new FPTree($conditionalTreeInput, $threshold, $item, $this->frequent[$item]);
            $subtreePatterns = $subtree->minePatterns($threshold);

            // Insert subtree patterns into main patterns dictionary.
            foreach (array_keys($subtreePatterns) as $pattern) {
                if (in_array($pattern, $patterns)) {
                    $patterns[$pattern] += $subtreePatterns[$pattern];
                } else {
                    $patterns[$pattern] = $subtreePatterns[$pattern];
                }
            }
        }

        return $patterns;
    }
}
