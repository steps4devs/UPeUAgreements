# UPeU Agreements Management System

## Spring Boot Migration Complete ✅

This project has been successfully migrated from Laravel/PHP to Spring Boot/Java with modern development practices.

### 🚀 Quick Start

1. **Prerequisites**
   - Java 17 or higher
   - Maven 3.6 or higher

2. **Run the application**
   ```bash
   mvn spring-boot:run
   ```

3. **Access the application**
   - **Web Dashboard**: http://localhost:8080/dashboard
   - **API Documentation**: http://localhost:8080/swagger-ui.html
   - **H2 Database Console**: http://localhost:8080/h2-console
     - JDBC URL: `jdbc:h2:mem:upeu_agreements`
     - Username: `sa`
     - Password: (leave empty)

### 📋 Features

#### ✅ Complete REST API
- **Entities (Entidades)**: `/api/v1/entidades`
- **Faculties (Facultades)**: `/api/v1/facultades`  
- **Careers (Carreras)**: `/api/v1/carreras`
- **Agreements (Convenios)**: `/api/v1/convenios`
- **Documents**: `/api/v1/documentos`

#### ✅ Professional Architecture
- **Entities**: JPA entities with proper relationships
- **DTOs**: Data Transfer Objects with validation
- **Mappers**: MapStruct for automatic mapping
- **Services**: Business logic layer
- **Controllers**: REST API endpoints
- **Security**: Spring Security integration

#### ✅ Modern Development Practices
- **Validation**: Comprehensive input validation
- **Error Handling**: Proper exception handling
- **Documentation**: OpenAPI/Swagger documentation
- **Testing**: H2 in-memory database for development
- **Logging**: Structured logging with SLF4J

### 📊 Business Domain

The system manages university agreements with the following entities:

- **Entidades**: External organizations/entities
- **Facultades**: University faculties  
- **Carreras**: Academic programs/careers
- **Convenios**: Agreements/contracts
- **Documentos**: Document attachments
- **Users**: System users

### 🔧 Technical Stack

- **Framework**: Spring Boot 3.2.0
- **Java**: 17
- **Database**: H2 (development), MySQL (production)
- **ORM**: Hibernate/JPA
- **Mapping**: MapStruct
- **Documentation**: SpringDoc OpenAPI
- **Security**: Spring Security
- **Build**: Maven

### 📝 API Examples

#### Get all entities
```bash
curl -X GET http://localhost:8080/api/v1/entidades
```

#### Create new entity
```bash
curl -X POST http://localhost:8080/api/v1/entidades \
  -H "Content-Type: application/json" \
  -d '{
    "nombreEntidad": "Nueva Entidad",
    "ubicacion": "Lima, Perú",
    "contacto": "contacto@entidad.com"
  }'
```

#### Get agreements expiring soon
```bash
curl -X GET http://localhost:8080/api/v1/convenios/expiring-soon
```

### 🔄 Migration Summary

This project was successfully migrated from Laravel to Spring Boot, maintaining all business logic and adding professional development practices:

1. **Database Layer**: Laravel migrations → JPA entities
2. **Business Logic**: Laravel models → Spring services  
3. **API Layer**: Laravel controllers → Spring REST controllers
4. **Validation**: Laravel validation → Bean Validation
5. **Documentation**: Manual docs → OpenAPI/Swagger
6. **Security**: Laravel auth → Spring Security

### 🗂️ Project Structure

```
src/
├── main/
│   ├── java/pe/edu/upeu/agreements/
│   │   ├── entity/          # JPA entities
│   │   ├── dto/             # Data Transfer Objects
│   │   ├── mapper/          # MapStruct mappers
│   │   ├── repository/      # Spring Data repositories
│   │   ├── service/         # Business logic
│   │   ├── controller/      # REST controllers
│   │   └── config/          # Configuration classes
│   └── resources/
│       ├── templates/       # Thymeleaf templates
│       ├── data.sql         # Sample data
│       └── application.properties
└── test/                    # Unit tests
```

### 🚀 Deployment

For production deployment:

1. Update `application.properties` with production database settings
2. Build the JAR: `mvn clean package`
3. Run: `java -jar target/agreements-1.0.0.jar`

### 📚 Additional Resources

- **Spring Boot Documentation**: https://spring.io/projects/spring-boot
- **Spring Data JPA**: https://spring.io/projects/spring-data-jpa
- **MapStruct**: https://mapstruct.org/
- **OpenAPI/Swagger**: https://springdoc.org/

---

**Migration completed successfully!** 🎉

The Laravel application has been fully migrated to Spring Boot with modern Java development practices, comprehensive API documentation, and professional architecture.