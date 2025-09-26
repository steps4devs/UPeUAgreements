package pe.edu.upeu.agreements.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

/**
 * Web Controller for basic web pages
 * 
 * @author UPeU Development Team
 */
@Controller
public class WebController {

    @GetMapping("/")
    public String home() {
        return "redirect:/swagger-ui.html";
    }

    @GetMapping("/dashboard")
    public String dashboard() {
        return "dashboard";
    }
}