INSERT INTO popularity (id_user, id_company, vote)
SELECT id_user, id_company, FLOOR(RAND() * 5) + 1
FROM (
  SELECT DISTINCT id_user, id_company
  FROM (
    SELECT 1 AS id_user UNION SELECT 2 UNION SELECT 3 
  ) AS u
  CROSS JOIN (
    SELECT 1 AS id_company UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION SELECT 31 UNION SELECT 32 UNION SELECT 33 UNION SELECT 34 UNION SELECT 35 UNION SELECT 36 UNION SELECT 37 UNION SELECT 38 UNION SELECT 39 UNION SELECT 40
  ) AS c
) AS uc
ORDER BY RAND()
LIMIT 100;
