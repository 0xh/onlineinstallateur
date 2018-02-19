
START TRANSACTION;

UPDATE `multi_lang` SET `content` = 'Thank you for your booking. <br/><br/>ID: {BookingID}<br/><br/>Services<br/>{Services}<br/><br/>Personal details<br/>Name: {Name}<br/>Phone: {Phone}<br/>Email: {Email}<br/><br/>This is the price for your booking<br/>Tax: {Price}<br/>Tax: {Tax}<br/>Total: {Total}<br/>Deposit required to confirm your booking: {Deposit}<br/><br/>Additional notes:<br/>{Notes}<br/><br/>Thank you,<br/>The Management' WHERE `model` = "pjCalendar" AND `field` = "confirm_tokens_client";

UPDATE `multi_lang` SET `content` = 'We''ve received the payment for your booking and it is now confirmed.<br/><br/>ID: {BookingID}<br/><br/>Thank you,<br/>The Management' WHERE `model` = "pjCalendar" AND `field` = "payment_tokens_client";

UPDATE `multi_lang` SET `content` = 'New booking has been made. <br/><br/>ID: {BookingID}<br/><br/>Services<br/>{Services}<br/><br/>Personal details<br/>Name: {Name}<br/>Phone: {Phone}<br/>Email: {Email}<br/><br/>Price<br/>Tax: {Price}<br/>Tax: {Tax}<br/>Total: {Total}<br/>Deposit required to confirm the booking: {Deposit}<br/><br/>Additional notes:<br/>{Notes}' WHERE `model` = "pjCalendar" AND `field` = "confirm_tokens_admin";

UPDATE `multi_lang` SET `content` = 'Booking deposit has been paid.<br/><br/>ID: {BookingID}' WHERE `model` = "pjCalendar" AND `field` = "payment_tokens_admin";

UPDATE `multi_lang` SET `content` = 'New appointment has been made.<br/><br/>ID: {BookingID}<br/><br/>Services<br/>{Services}<br/><br/>Personal details<br/>Name: {Name}<br/>Phone: {Phone}<br/>Email: {Email}<br/><br/>Additional notes:<br/>{Notes}' WHERE `model` = "pjCalendar" AND `field` = "confirm_tokens_employee";

UPDATE `multi_lang` SET `content` = 'Booking deposit has been paid.<br/><br/>ID: {BookingID}' WHERE `model` = "pjCalendar" AND `field` = "payment_tokens_employee";

UPDATE `multi_lang` SET `content` = 'Your booking has been cancelled.<br/><br/>ID: {BookingID}<br/><br/>Thank you,<br/>The Management' WHERE `model` = "pjCalendar" AND `field` = "cancel_tokens_client";

UPDATE `multi_lang` SET `content` = 'Booking has been cancelled.<br/><br/>ID: {BookingID}' WHERE `model` = "pjCalendar" AND `field` = "cancel_tokens_admin";

UPDATE `multi_lang` SET `content` = 'Booking has been cancelled.<br/><br/>ID: {BookingID}' WHERE `model` = "pjCalendar" AND `field` = "cancel_tokens_employee";

COMMIT;