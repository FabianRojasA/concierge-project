package com.jetnews.concierge.api.response

import androidx.annotation.Keep
import com.google.gson.JsonArray

@Keep
class PersonResponse {

    var message: String? = null
    var people: JsonArray? = null

}