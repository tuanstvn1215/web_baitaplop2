
DELIMITER // 

CREATE TRIGGER BEFORE_ChiTietDatHang_INSERT BEFORE INSERT ON `ChiTietDatHang` 
    FOR EACH ROW
    BEGIN
        select SoluongHang
            into @SoluongHang
            from HangHoa
            where MSHH=new.MSHH;
        if @SoluongHang>=new.SoLuong then
            UPDATE `HangHoa` 
                SET SoLuongHang = @SoluongHang - new.SoLuong
                WHERE MSHH =new.MSHH;
        else
            SIGNAL SQLSTATE '45000' set message_text=' Số lượng đặt hàng lớn hơn tồn kho, Số lượng tồn kho phải lớn hơn 0';
        end if;
       
    END;//
    
DELIMITER;
    FOR EACH ROW
    BEGIN
DELIMITER //

//
