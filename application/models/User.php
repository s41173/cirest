<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->tableName = 'customer';
    }
    
    private $tableName;
    protected $field = array('No_Cabang', 'No_Wilayah', 'No_Jalan', 'No_Pelanggan', 'Nama_Pelanggan', 'Jenis_Pelanggan',
                             'Alamat', 'No_Rumah', 'Tanggal_Pasang', 'BA_Pasang', 'No_Meter', 'Merk_Meter', 'Type_Meter',
                             'Status_Pelanggan', 'Tempat_Bayar', 'Uang_Jamin', 'Beban_Denda', 'Jml_Tunggakan', 'Awal_Tunggakan', 
                             'Tgl_Service', 'Jml_Service', 'Jml_Ganti_Meter', 'Rata_Rata', 'Stand_Bulan_Lalu', 'Stand_Akhir',
                             'Kd_Buku', 'Ket', 'Kd_Sampah', 'Kd_Saluran', 'ID_Pelanggan', 'Kondisi_M', 'Kolektif', 'letak'
                            );
    
    protected $field_infoair = array('instalasi', 'nama', 'tarif', 'register', 'MtrAwal', 'MtrAkhir',
                             'pakai', 'HargaAir', 'BiayaAdm', 'PerawatanMeter', 'Materai', 'Sampah', 'Jumlah',
                             'TanggalCatat', 'Cetak', 'bulan', 'tahun', 'alamat', 'lunas', 
                             'TanggalBayar', 'Kasir', 'Status_Pelanggan'
                            );
    
    protected $field_infononair = array('instalasi', 'nama', 'register', 'bukti1', 'tagihan',
                                        'lunas', 'bulan', 'tahun', 'tanggal'
                            );
    
    function get($limit=100)
    {
        $this->db->select($this->field);
        $this->db->from($this->tableName); 
        $this->db->limit($limit);
        return $this->db->get(); 
    }
    
    function search($no_pelanggan=null,$name=null,$id_pelanggan=null,$no_meter=null)
    {
        $this->db->select($this->field);
        $this->cek_null($no_pelanggan, 'No_Pelanggan');
        $this->cek_null($name, 'Nama_Pelanggan');
        $this->cek_null($id_pelanggan, 'ID_Pelanggan');
        $this->cek_null($no_meter, 'No_Meter');
        $this->db->limit(25);
        $this->db->from($this->tableName); 
        return $this->db->get(); 
    }
    
    protected function cek_null($val,$field)
    {
        if ($val == ""){return null;}
        elseif ($val == '0'){ return null; }
        else {return $this->db->where($field, $val);}
    }
    
    function get_by_id($uid)
    {
        $this->db->select($this->field);
        $this->db->where('id', $uid);
        $this->db->from($this->tableName); 
        return $this->db->get()->row(); 
    }
    
    function delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->tableName); // perintah untuk delete data dari db
    }

    function save($data)
    {
        if ($this->db->insert($this->tableName, $data)){
            return [  
                'id' => $this->db->insert_id(), 'success' => true, 'message' => 'data berhasil diinput'
            ];
        }
    }
    
    function infoair($instalasi=null){
        $this->db->select($this->field_infoair);
        $this->cek_null($instalasi, 'instalasi');
        $this->db->order_by('TanggalCatat', 'desc');
        $this->db->from('infoair'); 
        return $this->db->get(); 
    }
    
    function infononair($instalasi=null){
        $this->db->select($this->field_infononair);
        $this->cek_null($instalasi, 'instalasi');
        $this->db->order_by('tanggal', 'desc');
        $this->db->from('infononair'); 
        return $this->db->get(); 
    }

}

?>