package pe.edu.upeu.agreements.mapper;

import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import pe.edu.upeu.agreements.dto.UserDTO;
import pe.edu.upeu.agreements.entity.User;

import java.util.List;

/**
 * MapStruct mapper for User entity
 * 
 * @author UPeU Development Team
 */
@Mapper(componentModel = "spring")
public interface UserMapper {
    
    /**
     * Convert User entity to UserDTO (excludes password for security)
     */
    @Mapping(target = "password", ignore = true)
    UserDTO toDTO(User user);
    
    /**
     * Convert list of User entities to list of UserDTOs
     */
    List<UserDTO> toDTOList(List<User> users);
    
    /**
     * Convert UserDTO to User entity
     */
    @Mapping(target = "password", ignore = true) // Password handled separately
    @Mapping(target = "rememberToken", ignore = true)
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "conveniosCreados", ignore = true)
    @Mapping(target = "authorities", ignore = true)
    @Mapping(target = "username", ignore = true)
    @Mapping(target = "accountNonExpired", ignore = true)
    @Mapping(target = "accountNonLocked", ignore = true)
    @Mapping(target = "credentialsNonExpired", ignore = true)
    @Mapping(target = "enabled", ignore = true)
    User toEntity(UserDTO userDTO);
}