delimiter // 
CREATE TRIGGER new_book AFTER INSERT ON book 
FOR EACH ROW 
  BEGIN 
    UPDATE book_details SET tot_qty=tot_qty+1 WHERE ISBN=NEW.ISBN; 
    UPDATE book_details SET avail_qty=avail_qty+1 WHERE ISBN=NEW.ISBN; 
  END 
// 
delimiter ; 

delimiter // 
CREATE TRIGGER del_book AFTER DELETE ON book 
FOR EACH ROW 
  BEGIN 
    UPDATE book_details SET tot_qty=tot_qty-1 WHERE ISBN=OLD.ISBN; 
    UPDATE book_details SET avail_qty=avail_qty-1 WHERE ISBN=OLD.ISBN; 
  END 
// 
delimiter ; 

delimiter // 
CREATE TRIGGER new_dvd AFTER INSERT ON dvd 
FOR EACH ROW 
  BEGIN 
    UPDATE dvd_details SET tot_qty=tot_qty+1 WHERE title=NEW.title and publish_company=NEW.publish_company and release_date=NEW.release_date; 
    UPDATE dvd_details SET avail_qty=avail_qty+1 WHERE title=NEW.title and publish_company=NEW.publish_company and release_date=NEW.release_date; 
  END 
// 
delimiter ; 

delimiter // 
CREATE TRIGGER del_dvd AFTER DELETE ON dvd 
FOR EACH ROW 
  BEGIN 
    UPDATE dvd_details SET tot_qty=tot_qty-1 WHERE title=OLD.title and publish_company=OLD.publish_company and release_date=OLD.release_date; 
    UPDATE dvd_details SET avail_qty=avail_qty-1 WHERE title=OLD.title and publish_company=OLD.publish_company and release_date=OLD.release_date; 
  END 
// 
delimiter ;

delimiter // 
CREATE TRIGGER new_book_borrow AFTER INSERT ON book_borrow 
FOR EACH ROW 
  BEGIN 
    UPDATE book_details SET avail_qty=avail_qty-1 WHERE ISBN=(select ISBN from book where book_id=NEW.book_id); 
  END 
// 
delimiter ; 

delimiter // 
CREATE TRIGGER new_dvd_borrow AFTER INSERT ON dvd_borrow 
FOR EACH ROW 
  BEGIN 
    UPDATE dvd_details SET avail_qty=avail_qty-1 WHERE title=(select title from dvd where dvd_id=NEW.dvd_id)
                                                     and publish_company=(select publish_company from dvd where dvd_id=NEW.dvd_id)
                                                     and release_date=(select release_date from dvd where dvd_id=NEW.dvd_id); 
  END 
// 
delimiter ;
