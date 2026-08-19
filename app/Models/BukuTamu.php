<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    protected $table = 'pengunjung';

    protected $primaryKey = 'id_pengunjung';

    public $timestamps = false;

    public const CREATED_AT = 'created';

    protected $casts = [
        'created' => 'datetime',
    ];

    protected $fillable = [
        'identitas',
        'nomor',
        'nama_pengunjung',
        'id_jk',
        'nomortelepon',
        'alamat_pengunjung',
        'pejabat',
        'keperluan_pengunjung',
        'jumlah',
        'status_konfirmasi',
        'status_respon',
        'id_kebutuhan',
        'created',
        'no_hp',
        'instansi_alamat',
        'keperluan',
        'nama',
        'pegawai_temui',
        'jenis_kelamin',
        'anda_sendirian',
        'jumlah_rombongan',
        'usia',
    ];

    private const FORM_COLUMNS = [
        'no_hp' => 'nomortelepon',
        'instansi_alamat' => 'alamat_pengunjung',
        'keperluan' => 'keperluan_pengunjung',
        'nama' => 'nama_pengunjung',
        'pegawai_temui' => 'pejabat',
        'created_at' => 'created',
    ];

    public static function createFromForm(array $attributes): self
    {
        return static::create([
            'nomor' => 0,
            'identitas' => $attributes['identitas'],
            'nama_pengunjung' => $attributes['nama'],
            'id_jk' => $attributes['jenis_kelamin'] === 'Perempuan' ? 2 : 1,
            'usia' => $attributes['usia'],
            'nomortelepon' => $attributes['no_hp'] ?? null,
            'alamat_pengunjung' => $attributes['instansi_alamat'],
            'pejabat' => $attributes['pegawai_temui'] ?? null,
            'keperluan_pengunjung' => $attributes['keperluan'],
            'jumlah' => $attributes['anda_sendirian'] === 'Rombongan'
                ? (string) $attributes['jumlah_rombongan']
                : '1',
            'status_konfirmasi' => 0,
            'status_respon' => 0,
            'id_kebutuhan' => 6,
            'created' => now(),
        ]);
    }

    public function setAttribute($key, $value)
    {
        if (isset(self::FORM_COLUMNS[$key])) {
            $key = self::FORM_COLUMNS[$key];
        }

        if ($key === 'jenis_kelamin') {
            $key = 'id_jk';
            $value = $value === 'Perempuan' ? 2 : 1;
        }

        if ($key === 'anda_sendirian') {
            if ($value === 'Hanya saya') {
                parent::setAttribute('jumlah', '1');
            }

            return $this;
        }

        if ($key === 'jumlah_rombongan') {
            $key = 'jumlah';
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if ($key === 'jenis_kelamin') {
            return parent::getAttribute('id_jk') === 2 ? 'Perempuan' : 'Laki-laki';
        }

        if ($key === 'anda_sendirian') {
            return ((int) parent::getAttribute('jumlah')) > 1 ? 'Rombongan' : 'Hanya saya';
        }

        if (isset(self::FORM_COLUMNS[$key])) {
            $key = self::FORM_COLUMNS[$key];
        }

        if ($key === 'jumlah_rombongan') {
            return parent::getAttribute('jumlah');
        }

        return parent::getAttribute($key);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'buku_tamu_id', 'id_pengunjung');
    }
}