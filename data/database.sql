drop database web;

CREATE database web;
use web;
CREATE TABLE NhomHangHoa
(
	MaNhom char(23) PRIMARY KEY,
	TenNhom varchar(255) not null
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE HangHoa
(
	MSHH char(23) PRIMARY KEY,
	TenHH varchar(255) not null,
	Gia int not null,
	SoLuongHang tinyint not null,
	MaNhom char(23) not null,
	Hinh varchar(1000) not null,
	MoTaHH varchar(1000),
	CHECK(Gia>=0 and SoLuongHang>=0),
	CONSTRAINT fk_NhomHangHoa FOREIGN KEY (MaNhom) REFERENCES NhomHangHoa(MaNhom)

)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE NhanVien
(
	MSNV varchar(30) PRIMARY KEY,
	HoTenNV varchar(255) not null,
	ChucVu varchar(50) not null,
	DiaChi varchar(255) ,
	SoDienThoai varchar(10) not null,
	MatKhau varchar(255) not null
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE KhachHang
(
	MSKH varchar(30) PRIMARY KEY,
	HoTenKH varchar(255) not null,
	Email varchar(255) not null UNIQUE,
	DiaChi varchar(255),
	SoDienThoai varchar(10) not null,
	MatKhau varchar(255) not null
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE DatHang
(
	SoDonDH char(23) PRIMARY KEY,
	MSKH char(23) not null,
	MSNV char(23) not null ,
	NgayDH datetime DEFAULT NOW(),
	TrangThai varchar(10) not null,
	CONSTRAINT pk_KhachHang FOREIGN KEY (MSKH) REFERENCES KhachHang(MSKH),
	CONSTRAINT pk_NhanVien FOREIGN KEY (MSNV) REFERENCES NhanVien(MSNV)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE ChiTietDatHang
(
	SoDonDH char(23)not null,
	MSHH char(23) not null,
	SoLuong tinyint not null,
	GiaDatHang real,
	CHECK (SoLuong>=1),
	CONSTRAINT pk_ChiTietDatHang PRIMARY KEY (SoDonDH,MSHH),
	CONSTRAINT pk_HangHoa FOREIGN KEY (MSHH) REFERENCES HangHoa(MSHH),
	CONSTRAINT pk_DatHang FOREIGN KEY (SoDonDH) REFERENCES DatHang(SoDonDH)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
insert into NhanVien
values ('NV_123','Trần Anh Tuấn','Admin','Sóc Trăng','0899016864','123123'),
 		('NV_124','Nguyễn Văn Tèo','NhanVien','Cần Thơ','0124257887','123123');
insert into  KhachHang
values ('KH_123','Trần Thị Thảo','dfsdsfsdfsd@gmail.com','Bạc Liêu','0355245645','1231223'),
		('KH_124','Trần Anh Khoa','dfsdsffsdfsd@gmail.com','Bạc Liêu','0355243645','1231223');
insert into NhomHangHoa 
values ('TV001','TIVI màn hình cong'),
 		('COC12','TIVI màn hình phẳng');
insert into HangHoa
values ('COC12','TiVi Samsmung',10000000,12,'TV001','dfsdsfsdfsd@gmail.com','Đây là TV'),
		('COC14','TiVi LG',10000000,10,'COC12','dfsdfsdfsd@gmail.com','Đây là TV');


INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `TrangThai`) VALUES ('COC12', 'KH_123', 'NV_123', CURRENT_TIMESTAMP, 'chua xem');


