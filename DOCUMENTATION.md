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
