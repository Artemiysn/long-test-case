SET @yearStart = DATE_SUB(CURDATE(), interval 22 year);
SET @yearEnd = DATE_SUB(CURDATE(), interval 18 year);

SELECT users.name, COUNT(pn.user_id)
FROM users
LEFT JOIN phone_numbers pn ON users.id = pn.user_id
WHERE
  users.gender = 'f'
AND
  -- сравниваем таким образом, чтобы наш индекс на колонке даты рождения сработал
  users.birth_date >= @yearStart AND users.birth_date <= @yearEnd
GROUP BY
  users.id;
