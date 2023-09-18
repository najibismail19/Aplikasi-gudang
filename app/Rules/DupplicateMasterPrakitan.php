<?php

namespace App\Rules;

use App\Models\MasterPrakitan;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class DupplicateMasterPrakitan implements ValidationRule, DataAwareRule, ValidatorAwareRule
{

    private array $data;
    private Validator $validator;

    public function setData(array $data) : DupplicateMasterPrakitan
    {
        $this->data = $data;
        return $this;
    }

    public function setValidator(Validator $validator) : DupplicateMasterPrakitan
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
        $kode_produk_jadi = $this->data["kode_produk_jadi"];
        $kode_produk_mentah = $value;
        $query = MasterPrakitan::where("kode_produk_jadi", $kode_produk_jadi)
                        ->where("kode_produk_mentah", $kode_produk_mentah)
                        ->first();

        $cekIsActive = MasterPrakitan::select("*")->with(["produk_jadi", "produk_mentah"])
                        ->where("kode_produk_jadi", $kode_produk_jadi)
                        ->where("is_active", true)
                        ->get();
        if (count($cekIsActive) > 0) {
            $fail("Produk Sudah Pernah Dirakit");
        } else if($query) {
            $fail("Produk Sudah Tersedia");
        }
    }
}
