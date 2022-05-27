# API documentation

[[_TOC_]]

## Authorization

### POST `/auth/login`

Parameters:

- phone (required)
- password (required)

Example:

```
{
	"phone": "901234567",
	"Password": "some_password"
}
```

### POST `/auth/logout`

without parameter

### POST `/auth/refresh`

without parameter

### POST `/auth/me`

without parameter

## CRUD for users

### GET `/users`

Parameters:

- search (optional, any string to search from phone and name fields)
- name (optional, for filtering by name)
- phone (optional, for filtering by phone)
- lang (optional, for filtering by language)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Example:

```
{
	"search": "Something",
	"name": "Some name",
	"phone": "901234567",
	"lang": "uz",
    "column": "created_at",
    "order": "desc
}
```

### POST `/users`

Parameters:

- phone (required, integer, unique)
- name (required)
- password (required, min length 6)
- lang (optional, value can be one of 'uz','ru','en')
- role (required, value can be one of 'CEO', 'CFO', 'Manager', 'Cashier')

Example:

```
{
	"phone": "901234567",
	"name": "Some name",
	"password": "pas456",
    "lang": "uz",
    "role": "CFO
}
```

### GET `/users/{id}`

No params

### PUT `/users/{id}`

Parameters:

- phone (optional, integer, unique)
- name (optional)
- password (optional, min length 6)
- lang (optional, value can be one of 'uz','ru','en')
- role (required, value can be one of 'CEO', 'CFO', 'Manager', 'Cashier')

Example:

```
{
	"phone": "901234567",
	"name": "Some name",
	"password": "pas456",
    "lang": "uz",
    "role": "CFO
}
```

### DELETE `/users/{id}`

No params

## Seeing roles and permissions, syncing permissions to role

### GET `/roles`

Parameters:

- search (optional, any string to search from name field)
- with_permissions (optional, boolean, true)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Example:

```
{
	"search": "Something",
	"with_permissions": true,
    "column": "created_at",
    "order": "desc
}
```

### GET `/roles/{id}`

No params

### GET `/roles/{id}/permissions`

Parameters:

- search (optional, any string to search from phone and name fields)
- with_roles (optional, boolean, true)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Example:

```
{
	"search": "Something",
	"with_roles": true,
    "column": "created_at",
    "order": "desc
}
```

### PUT `/roles/{id}/permissions`

Parameters:

- permissions (required, comma separated permissions inside the string)

Example:

```
{
	"permissions":"See users,Attach role to user"
}
```

### GET `/permissions`

Parameters:

- search (optional, any string to search from phone and name fields)
- with_roles (optional, boolean, true)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Example:

```
{
	"search": "Something",
	"with_roles": true,
    "column": "created_at",
    "order": "desc
}
```

### GET `/permissions/{id}`

No params

## CRUD for currencies

### GET `/currencies`

Parameters:

- search (optional, any string to search from code, ccy, ccynm_uz, ccynm_uzc, ccynm_ru and ccynm_en fields)
- code (optional, for filtering by code)
- ccy (optional, for filtering by ccy)
- ccynm_uz (optional, for filtering by ccynm_uz)
- ccynm_uzc (optional, for filtering by ccynm_uzc)
- ccynm_ru (optional, for filtering by ccynm_ru)
- ccynm_en (optional, for filtering by ccynm_en)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Example:

```
{
	"search": "Something",
	"code": 840,
	"ccy": "USD",
	"ccynm_uz": "AQSH dollari",
	"ccynm_uzc": "АҚШ доллари",
	"ccynm_ru": "Доллар США",
	"ccynm_en": "US Dollar",
    "column": "created_at",
    "order": "desc
}
```

### POST `/currencies`

Parameters:

- code (required, integer)
- ccy (required, string)
- ccynm_uz (required, string)
- ccynm_uzc (required, string)
- ccynm_ru (required, string)
- ccynm_en (required, string)

Example:

```
{
	"code": 840,
	"ccy": "USD",
	"ccynm_uz": "AQSH dollari",
	"ccynm_uzc": "АҚШ доллари",
	"ccynm_ru": "Доллар США",
	"ccynm_en": "US Dollar",
}
```

### GET `/currencies/{id}`

No params

### PUT `/currencies/{id}`

Parameters:

- code (optional, integer)
- ccy (optional, string)
- ccynm_uz (optional, string)
- ccynm_uzc (optional, string)
- ccynm_ru (optional, string)
- ccynm_en (optional, string)

Example:

```
{
	"code": 840,
	"ccy": "USD",
	"ccynm_uz": "AQSH dollari",
	"ccynm_uzc": "АҚШ доллари",
	"ccynm_ru": "Доллар США",
	"ccynm_en": "US Dollar",
}
```

### DELETE `/currencies/{id}`

No params

## CRUD for firms

### GET `/firms`

Parameters:

- search (optional, any string to search from name)
- column (optional, for ordering by column name)
- order (optional, for ordering ascendant and descendant, values can be 'asc' or 'desc')

Example:

```
{
	"search": "Something",
    "column": "created_at",
    "order": "desc
}
```

### POST `/firms`

Parameters:

- name (required, string)

Example:

```
{
	"name": "Some Firm",
}
```

### GET `/firms/{id}`

No params

### PUT `/firms/{id}`

Parameters:

- name (optional, string)

Example:

```
{
	"name": "Some Firm",
}
```

### DELETE `/firms/{id}`

No params
