# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer  {your-token-here}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Para obtener un token, realiza un POST a `/api/login` con tus credenciales. El token JWT será retornado en la respuesta.
