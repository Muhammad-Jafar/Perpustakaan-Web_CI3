<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Peminjaman extends CI_Model {

	public function list_peminjam_siswa() {
		$q = $this->db->select('*')->from ('anggota')
					->where ('kategori_anggota', 'siswa')
					->get();
		return $q->result();
	}

	public function list_peminjam_guru() {
		$q = $this->db->select('*')->from ('anggota')
					->where ('kategori_anggota', 'guru')
					->get();
		return $q->result();
	}

	public function list_buku() {
		$q = $this->db->select('*')->get('buku');
		return $q->result();
	}

	public function list_kategori_buku() {
		$q = $this->db->select('*')->get('kategori_buku');
		return $q->result();
	}

    public function data_peminjaman_siswa() {
        $q = $this->db->select(' t.id_transaksi, t.kode_pinjam, t.tgl_pinjam, t.tgl_kembali, 
								 t.id_anggota, t.id_buku, t.status, 
                                 a.nama_anggota, a.kategori_anggota,
                                 b.judul_buku, d.denda')
                      ->from ('transaksi as t')
                      ->join ('anggota as a', 'a.id_anggota = t.id_anggota', 'LEFT')
                      ->join ('buku as b', 'b.id_buku = t.id_buku', 'LEFT')
					  ->join ('denda as d', 'd.id_transaksi = t.id_transaksi', 'LEFT')
					  ->where('t.status', 'dipinjam')
					  ->where('a.kategori_anggota', 'siswa')
                      ->get();
        return $q->result();
    }

	public function data_peminjaman_guru() {
        $q = $this->db->select(' t.id_transaksi, t.kode_pinjam, t.tgl_pinjam, t.tgl_kembali, 
								 t.id_anggota, t.id_buku, t.status, 
								 a.nama_anggota, a.kategori_anggota,
                                 b.judul_buku, d.denda')
                      ->from ('transaksi as t')
					  ->join ('anggota as a', 'a.id_anggota = t.id_anggota', 'LEFT')
                      ->join ('buku as b', 'b.id_buku = t.id_buku', 'LEFT')
					  ->join ('denda as d', 'd.id_transaksi = t.id_transaksi', 'LEFT')
					  ->where('t.status', 'dipinjam')
					  ->where('a.kategori_anggota', 'guru')
                      ->get();
        return $q->result();
    }

    public function data_pinjam_list_ajax($json) {
		$new_arr=array();$i=1;
		foreach ($json as $key => $value) {
			$value->no=$i;
			switch ($value->status) {
				case 'dipinjam':
					$label = 'warning';
				break;
				case 'dikembalikan':
					$label = 'success';
			};

			$tgl_kembali = new DateTime( $value->tgl_kembali); // hitung hari telat kembalikan
			$tgl_sekarang = new DateTime();
			$selisih = $tgl_sekarang->diff($tgl_kembali)->format("%a");
			$diff  = date_diff( date_create($value->tgl_pinjam), $tgl_sekarang );
			$value->lama_pinjam = $diff->format('%d hari'); // hitung hari di tabel

			if ($tgl_kembali >= $tgl_sekarang OR $selisih == 0) {
				$value->denda = "<span class='badge badge-success' style=font-size:13px; >Tidak kena denda</span>";
			} else {
				$value->denda ="Telat <b style = 'color: red;font-size:13px;' >".$selisih."</b> Hari <br>
				<span class='badge badge-danger' style=font-size:13px; > Denda perhari = Rp.500</span>";
			}

			$value->tgl_pinjam = date_format( date_create($value->tgl_pinjam), 'd-m-Y');
			$value->tgl_kembali = date_format( date_create($value->tgl_kembali), 'd-m-Y');
			$value->status = '<label class="badge badge-'.$label.' text-uppercase" style=font-size:13px;>'.$value->status.'</label>';
			$new_arr[]=$value;
			$i++;
		}
		return $new_arr;
	}


	//fungsi auto show data by search char with ajax
	function search_nama_siswa($nama_anggota) {
        $this->db->like('nama_anggota', $nama_anggota , 'both');
		$this->db->where('kategori_anggota', 'siswa');
        $this->db->order_by('nama_anggota', 'ASC');
        $this->db->limit(10);
		return $this->db->get('anggota')->result();
    }

	function search_nama_guru($nama_anggota) {
        $this->db->like('nama_anggota', $nama_anggota , 'both');
		$this->db->where('kategori_anggota', 'guru');
        $this->db->order_by('nama_anggota', 'ASC');
        $this->db->limit(10);
		return $this->db->get('anggota')->result();
    }

	function search_judul_buku($judul_buku) {
        $this->db->like('judul_buku', $judul_buku , 'both');
        $this->db->order_by('judul_buku', 'ASC');
        $this->db->limit(10);
        return $this->db->get('buku')->result();
    }

	public function peminjaman_add_new( $id_anggota, $kode_pinjam, $id_buku, $qt_pinjam, $tgl_pinjam, $tgl_kembali) {
		$d_t_d = array( 'id_anggota'   	=> $id_anggota,
						'id_buku' 	 	=> $id_buku,
						'kode_pinjam'	=> $kode_pinjam,
						'qt_pinjam'		=> $qt_pinjam,
						'tgl_pinjam' 	=> $tgl_pinjam,
						'tgl_kembali' 	=> $tgl_kembali );
		
		$this->db->insert('transaksi', $d_t_d);
		$this->session->set_flashdata('msg_alert', 'Transaksi peminjam baru berhasil ditambahkan');
	}

	public function minstok( $id_anggota,  $id_buku, $tgl_kembali ) {
		$d_t_d = array( 'id_anggota'   	=> $id_anggota,
						'id_buku' 	 	=> $id_buku,
						'tgl_kembali'	=> $tgl_kembali );
		
		$this->db->insert('denda', $d_t_d);
	}

	//buat kode peminjaman otomatis generate
	public function buatkodepinjam() {
		$this->db->select('RIGHT(transaksi.kode_pinjam, 4) as kodepinjam', FALSE);
		$this->db->order_by('kodepinjam','DESC');    
		$this->db->limit(1);    

		$query = $this->db->get('transaksi');
			if($query->num_rows() > 0) {      
				 $data = $query->row();
				 $kode = intval($data->kodepinjam) + 1; 
			}
			else { $kode = 1; }
		$batas = str_pad($kode, 4, "0", STR_PAD_LEFT);    
		$kodetampil = "PJ-". $batas;
		return $kodetampil;  
	}
	
	public function kembalikan_buku($id_transaksi) {
	
		$q = array ( 'status' 			=> 'dikembalikan',
					 'tgl_dikembalikan' => date('Y-m-d'),
					 'qt_pinjam' 		=> '0'
					);
		$this->db->where('id_transaksi', $id_transaksi)->update('transaksi', $q);
	}
}
