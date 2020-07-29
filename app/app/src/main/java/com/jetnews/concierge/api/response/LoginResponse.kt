package com.jetnews.concierge.api.response

import androidx.annotation.Keep
import com.google.gson.JsonObject

@Keep
class LoginResponse {


    var user: JsonObject? = null
    var token: String? = null
    var token_expires_at: String? = null

}