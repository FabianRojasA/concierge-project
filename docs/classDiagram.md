# The class Diagram
@startuml

class Person{
    -String rut
    -String name
    -Integer phone  
    -String email
    
    
}

class Visit{
    -String rut
    -String name
    -String adress
    -Date date
    -Enum Relationship
    -String type
}

enum Relationship{
    CLOSE RELATIVE   
    VISITOR
    ENTERPRISE
}

@enduml
