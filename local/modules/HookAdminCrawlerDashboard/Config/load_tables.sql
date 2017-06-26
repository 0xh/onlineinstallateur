insert into crawler_product_base (product_id,active,action_required,created_at)
select product_id,1,0,now()
from product_sale_elements
where ean_code is not null