<?php

namespace App\Rules;

use App\Models\DetailPembelian;
use Closure;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Contracts\Validation\DataAwareRule;

class DupplicateProduk implements ValidationRule, DataAwareRule, ValidatorAwareRule
{
    private array $data;
    private Validator $validator;

    public function setData(array $data) : DupplicateProduk
    {
        $this->data = $data;
        return $this;
    }

    public function setValidator(Validator $validator) : DupplicateProduk
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $no_pembelian = $this->data["no_pembelian"];
        $kode_produk = $value;
        $query = DetailPembelian::where("no_pembelian", $no_pembelian)
                        ->where("kode_produk", $kode_produk)
                        ->first();
        if($query) {
            $fail("Produk Sudah Tersedia");
        }
    }
}
