SELECT offering_types.offering_name,
       languages.language_name,
       `users`.`name`                   AS `full_name`,
       users.phone,
       `lbc`.`offerings`.`id`           AS `id`,
       `lbc`.`offerings`.`service_id`   AS `service_id`,
       `lbc`.`offerings`.`service_date` AS `service_date`,
       lbc.offerings.total_amount
       + lbc.offerings.check_amount     AS total_amount
FROM   ((((`lbc`.`services`
           left JOIN `lbc`.`languages`
             ON(( `lbc`.`services`.`language_id` = `lbc`.`languages`.`id` )))
          JOIN `lbc`.`offering_types`
            ON(( `lbc`.`services`.`offering_type_id` =
                 `lbc`.`offering_types`.`id` )))
         JOIN `lbc`.`offerings`
           ON(( `lbc`.`services`.`id` = `lbc`.`offerings`.`service_id` )))
        JOIN `lbc`.`users`
          ON(( `lbc`.`offerings`.`user_id` = `lbc`.`users`.`id` )))
WHERE  offerings.service_date = "2025-04-27"
       AND phone IS NOT NULL
ORDER  BY `languages`.`language_name` ASC; 