# The class Diagram
@startuml

Person <|-- Visit


class Person{
    -String rut
    -String name
    -Integer phone  
    -String email
}

class Visit{
    -String adress
    -ZonedDateTime fecha
    -Enum Relationship
    -Enum Typo
}

class User{
    -String name
    -String email
    -String password
    
}

enum Relationship{
    CLOSE RELATIVE   
    VISITOR
    ENTERPRISE
}

enum Type{
    DELIVERY
    SHIPPING
}

@enduml
