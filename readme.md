## Project user
A user management and authentication package for the Drago Project.
Provides secure and type-consistent access to user data, authentication, tokens, and access protection.

## Main features
- User identity management via User and UserIdentity
- Authentication and token management via UserRepository
- Centralized access protection via the UserRequireLogged trait
- Type-safe exceptions and interfaces (UserIdentityException, UserToken)
- UsersEntity data entity for working with users in the database
- Easy integration with Nette DI
