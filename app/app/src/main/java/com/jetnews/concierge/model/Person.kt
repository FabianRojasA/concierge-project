package com.jetnews.concierge.model

import androidx.annotation.Keep

@Keep
class Person(
        var id: String?,
        var rut: String?,
        var name: String?,
        var phone: String?,
        var email: String?,
        var created_at: String?,
        var updated_at: String?) {

    override fun toString(): String {
        return "Rut: " + rut + "   Nombre: " + name
    }

}

