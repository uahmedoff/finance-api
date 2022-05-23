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
