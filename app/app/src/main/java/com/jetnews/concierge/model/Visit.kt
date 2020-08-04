package com.jetnews.concierge.model

import androidx.annotation.Keep

@Keep
class Visit (
        var rut: String?,
        var name: String?,
        var adress: String?,
        var date: String?,
        var relationship: Relationship?,
        var type: String?
) {

}

enum class Relationship {
    CLOSE_RELATIVE, VISITOR, ENTERPRISE
}